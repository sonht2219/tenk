<?php


namespace App\Service\Contract;


use App\User;

interface DtoBuilderService
{
    /**
     * @param User $user
     * @return mixed
     */
    public function buildUserDto(User $user);
}
