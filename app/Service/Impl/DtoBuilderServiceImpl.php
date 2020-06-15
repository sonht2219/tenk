<?php


namespace App\Service\Impl;


use App\Helper\Constant;
use App\Service\Contract\DtoBuilderService;
use App\User;

class DtoBuilderServiceImpl implements DtoBuilderService
{

    /**
     * @inheritDoc
     */
    public function buildUserDto(User $user)
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'status' => $user->status,
            'created_at' => $user->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $user->updated_at->format(Constant::GLOBAL_TIME_FORMAT)
        ];
    }
}
