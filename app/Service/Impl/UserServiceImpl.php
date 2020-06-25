<?php


namespace App\Service\Impl;


use App\Enum\Type\UploadFolder;
use App\Exceptions\ExecuteException;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Repositories\Contract\UserRepository;
use App\Repositories\Contract\WalletRepository;
use App\Repositories\Criteria\Common\BelongToUserCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Service\Contract\FileService;
use App\Service\Contract\UserService;
use App\User;
use Carbon\Carbon;

class UserServiceImpl implements UserService
{
    private WalletRepository $walletRepo;
    private FileService $fileService;
    private UserRepository $userRepo;

    public function __construct(WalletRepository $walletRepo, UserRepository $userRepo,  FileService $fileService)
    {
        $this->walletRepo = $walletRepo;
        $this->fileService = $fileService;
        $this->userRepo = $userRepo;
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
}
