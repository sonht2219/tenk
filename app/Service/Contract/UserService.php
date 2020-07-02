<?php


namespace App\Service\Contract;


use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface UserService
{
    public function wallet(User $user);
    public function updateProfile(UpdateProfileUserRequest $req, User $user);
    public function countByStatus($status);

    public function createUser(UserRequest $req): User;
    public function listUser(Request $req): LengthAwarePaginator;
    public function singleUser($id): User;
    public function editUser($id, UserRequest $req): User;
    public function deleteUser($id): User;
}
