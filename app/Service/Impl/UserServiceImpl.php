<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Enum\Type\UploadFolder;
use App\Exceptions\ExecuteException;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\Contract\BotRepository;
use App\Repositories\Contract\UserRepository;
use App\Repositories\Contract\WalletRepository;
use App\Repositories\Criteria\Common\BelongToUserCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\Common\WithRelationsCriteria;
use App\Repositories\Criteria\User\UserSearchCriteria;
use App\Service\Contract\FileService;
use App\Service\Contract\UserService;
use App\Service\Traits\GenerateIdUserTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{
    use GenerateIdUserTrait;
    private WalletRepository $walletRepo;
    private FileService $fileService;
    private UserRepository $userRepo;
    /**
     * @var BotRepository
     */
    private BotRepository $botRepository;

    public function __construct(WalletRepository $walletRepo, UserRepository $userRepo,  FileService $fileService, BotRepository $botRepository)
    {
        $this->walletRepo = $walletRepo;
        $this->fileService = $fileService;
        $this->userRepo = $userRepo;
        $this->botRepository = $botRepository;
        $this->setUserRepositoryForGenerateId($userRepo);
    }

    public function wallet(User $user)
    {
        $this->walletRepo->pushCriteria(new BelongToUserCriteria($user->id));
        return $this->walletRepo->firstOrFail();
    }

    public function updateProfile(UpdateProfileUserRequest $req, User $user)
    {
        $data = $this->filterDataUpdateProfile($req);
        if (isset($data['avatar_file']))
            $data['avatar'] = $this->fileService->storeFile($data['avatar_file'], UploadFolder::AVATARS);
        if (isset($data['birthday']))
            $data['birthday'] = Carbon::createFromTimestampMs($data['birthday']);

        $user->fill($data);
        return $this->userRepo->save($user);
    }

    public function filterDataUpdateProfile(UpdateProfileUserRequest $req) {
        $fillable = ['name', 'birthday', 'avatar_file'];
        return array_filter(filter_data($req->all()), fn ($key) => in_array($key, $fillable), ARRAY_FILTER_USE_KEY);
    }

    public function countByStatus($status)
    {
        if (is_numeric($status))
            $this->userRepo->pushCriteria(new HasStatusCriteria($status));

        return $this->userRepo->count();
    }

    public function createUser(UserRequest $req): User
    {
        $reducedData = [
            'id' => $this->generateId(),
            'password' => Hash::make($req->password),
            'birthday' => Carbon::createFromTimestampMs($req->birthday),
        ];
        $user = $this->userRepo->create($reducedData + $req->filteredData());

        if ($req->is_bot) {
            $this->botRepository->create([
                'user_id' => $user->id,
                'limit_per_buy' => 10
            ]);
        }

        return $user;
    }

    public function listUser(Request $req): LengthAwarePaginator
    {
        $search = $req->get('search');
        $status = $req->get('status');
        $limit = $req->get('limit') ?: 10;

        if ($search)
            $this->userRepo->pushCriteria(new UserSearchCriteria($search));
        if ($status)
            $this->userRepo->pushCriteria(new HasStatusCriteria($status));

        return $this->userRepo->paginate($limit);
    }

    public function singleUser($id): User
    {
        return $this->userRepo->findByIdWithRelation($id, ['wallet']);
    }

    public function editUser($id, UserRequest $req): User
    {
        $data = $req->filteredData();
        $user = $this->singleUser($id);

        if (isset($data['birthday']))
            $data['birthday'] = Carbon::createFromTimestampMs($data['birthday']);
        if (isset($data['password']))
            $data['password'] = Hash::make($data['password']);

        $user->fill($data);

        return $this->userRepo->save($user);
    }

    public function deleteUser($id): User
    {
        $user = $this->singleUser($id);
        $user->status = CommonStatus::INACTIVE;
        return $this->userRepo->save($user);
    }
}
