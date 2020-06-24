<?php


namespace App\Service\Contract;


use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\User;

interface UserService
{
    public function wallet(User $user);
    public function updateProfile(UpdateProfileUserRequest $req, User $user);
}
