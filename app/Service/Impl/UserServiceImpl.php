<?php


namespace App\Service\Impl;


use App\Enum\Type\UploadFolder;
use App\Exceptions\ExecuteException;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Repositories\Contract\WalletRepository;
use App\Repositories\Criteria\Common\BelongToUserCriteria;
use App\Service\Contract\FileService;
use App\Service\Contract\UserService;
use App\User;

class UserServiceImpl implements UserService
{
    private WalletRepository $walletRepo;
    private FileService $fileService;

    public function __construct(WalletRepository $walletRepo, FileService $fileService)
    {
        $this->walletRepo = $walletRepo;
        $this->fileService = $fileService;
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

    }

    public function filterDataUpdateProfile(UpdateProfileUserRequest $req) {
        $fillable = ['email', 'name', 'avatar_file'];
        return array_filter(filter_data($req->all()), fn ($key) => in_array($key, $fillable), ARRAY_FILTER_USE_KEY);
    }
}
