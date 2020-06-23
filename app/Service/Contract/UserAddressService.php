<?php


namespace App\Service\Contract;


use App\Http\Requests\UserAddressCreateRequest;
use App\Http\Requests\UserAddressEditRequest;
use App\Models\UserAddress;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UserAddressService
{
    public function create(User $user, UserAddressCreateRequest $req): UserAddress;
    public function edit($id, User $user, UserAddressEditRequest $req): UserAddress;
    public function delete($id, User $user): UserAddress;
    public function single($id, User $user): UserAddress;
    public function singleDefault(User $user): UserAddress;
    public function list(User $user, Request $req): Collection;
}
