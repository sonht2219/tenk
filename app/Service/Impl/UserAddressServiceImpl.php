<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Enum\Type\UserAddressType;
use App\Exceptions\ExecuteException;
use App\Http\Requests\UserAddressCreateRequest;
use App\Http\Requests\UserAddressEditRequest;
use App\Models\UserAddress;
use App\Repositories\Contract\UserAddressRepository;
use App\Repositories\Criteria\Common\BelongToUserCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\UserAddress\HasUserIdCriteria;
use App\Repositories\Criteria\UserAddress\UserAddressHasTypeCriteria;
use App\Repositories\Criteria\UserAddress\UserAddressWithRelationCriteria;
use App\Service\Contract\UserAddressService;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserAddressServiceImpl implements UserAddressService
{
    private UserAddressRepository $userAddressRepo;

    public function __construct(UserAddressRepository $userAddressRepo)
    {
        $this->userAddressRepo = $userAddressRepo;
    }

    public function create(User $user, UserAddressCreateRequest $req): UserAddress
    {
        $user_address = (new UserAddress())->fill($req->filteredData());
        $user_address->user_id = $user->id;
        $exist_address = $this->userAddressRepo->existUserAddress($user->id);
        if (!$exist_address && (!$user_address->type || $user_address->type != UserAddressType::DEFAULT))
            $user_address->type = UserAddressType::DEFAULT;
        if ($exist_address && $user_address->type == UserAddressType::DEFAULT)
            $this->userAddressRepo->updateDefaultToNormalType($user->id);
        return $this->userAddressRepo->save($user_address);
    }

    public function edit($id, User $user, UserAddressEditRequest $req): UserAddress
    {
        $type = $req->get('type');
        /** @var UserAddress $user_address */
        $user_address = $this->single($id, $user);
        if ($user_address->type == UserAddressType::DEFAULT && $type == UserAddressType::NORMAL)
            throw new ExecuteException(__('Không thể bỏ chọn địa chỉ mặc định. Bạn có thể chọn địa chỉ khác làm địa chỉ mặc định'));
        if ($user_address->type == UserAddressType::NORMAL && $type == UserAddressType::DEFAULT)
            $this->userAddressRepo->updateDefaultToNormalType($user->id);
        return $this->userAddressRepo->update($req->filteredData(), $id);
    }

    public function delete($id, User $user): UserAddress
    {
        /** @var UserAddress $user_address */
        $user_address = $this->single($id, $user);
        if ($user_address->type == UserAddressType::DEFAULT)
            throw new ExecuteException(__('Không thể xóa địa chỉ mặc định'));

        return $this->userAddressRepo->update(['status' => CommonStatus::INACTIVE], $id);
    }

    public function single($id, User $user): UserAddress
    {
        /** @var UserAddress $user_address */
        $user_address = $this->userAddressRepo->find($id);
        if ($user_address->user_id != $user->id)
            throw new ExecuteException(__('Địa chỉ không phải của bạn'));
        return $user_address;
    }

    public function singleDefault(User $user): UserAddress
    {
        $this->userAddressRepo->pushCriteria(new BelongToUserCriteria($user->id));
        $this->userAddressRepo->pushCriteria(new UserAddressHasTypeCriteria(UserAddressType::DEFAULT));
        $this->userAddressRepo->pushCriteria(UserAddressWithRelationCriteria::class);
        return $this->userAddressRepo->firstOrFail();
    }

    public function list(User $user, Request $req): Collection
    {
        $this->userAddressRepo->pushCriteria(new BelongToUserCriteria($user->id));
        $this->userAddressRepo->pushCriteria(new HasStatusCriteria(CommonStatus::ACTIVE));
        $this->userAddressRepo->pushCriteria(UserAddressWithRelationCriteria::class);
        return  $this->userAddressRepo->all();
    }
}
