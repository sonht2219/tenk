<?php


namespace App\Repositories\Contract;


use App\Repositories\Common\Repository;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserRepository extends Repository
{
    /**
     * @param string $email
     * @return User
     * @throws ModelNotFoundException
     */
    public function findByEmailOrFails(string $email): User;
}
