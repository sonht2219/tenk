<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\UpdateProfileUserRequest;

class UserController extends Controller
{
    public function wallet() {}
    public function updateProfile(UpdateProfileUserRequest $req) {
        return array_filter(filter_data($req->all()), fn ($key) => in_array($key, ['password', 'old_password']), ARRAY_FILTER_USE_KEY);
    }
}
