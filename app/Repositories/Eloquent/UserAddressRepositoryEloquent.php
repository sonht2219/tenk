<?php


namespace App\Repositories\Eloquent;


use App\Enum\Status\CommonStatus;
use App\Enum\Type\UserAddressType;
use App\Models\UserAddress;
use App\Repositories\Common\RepositoryEloquent;
use App\Repositories\Contract\UserAddressRepository;

class UserAddressRepositoryEloquent extends RepositoryEloquent implements UserAddressRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return UserAddress::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function updateDefaultToNormalType($user_id)
    {
        return $this->model->newQuery()
            ->where('user_id', $user_id)
            ->where('type', UserAddressType::DEFAULT)
            ->update(['type' => UserAddressType::NORMAL]);
    }

    public function existUserAddress($user_id): bool
    {
        return $this->model->newQuery()
            ->where('user_id', $user_id)
            ->where('status', CommonStatus::ACTIVE)
            ->exists();
    }
}
