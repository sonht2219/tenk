<?php


namespace App\Repositories\Contract;


use App\Repositories\Common\Repository;

interface UserAddressRepository extends Repository
{
    public function updateDefaultToNormalType($user_id);
    public function existUserAddress($user_id): bool;
}
