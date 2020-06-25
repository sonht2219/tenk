<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\UserService;

class UserController extends Controller
{
    use AuthorizedController;

    private UserService $userService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(UserService $userService, DtoBuilderService $dtoBuilder)
    {
        $this->userService = $userService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function wallet() {
        return $this->userService->wallet($this->user());
    }
    public function updateProfile(UpdateProfileUserRequest $req) {
        return $this->dtoBuilder->buildUserDto($this->userService->updateProfile($req, $this->user()));
    }
}
