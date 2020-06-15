<?php


namespace App\Repositories\Eloquent;


use App\Exceptions\ExecuteException;
use App\Repositories\Common\RepositoryEloquent;
use App\Repositories\Contract\UserRepository;
use App\User;

class UserRepositoryEloquent extends RepositoryEloquent implements UserRepository
{
    public function model()
    {
        return User::class;
    }

    /**
     * @inheritDoc
     */
    public function findByEmailOrFails(string $email): User
    {
        return $this->model
            ->where('email', $email)
            ->firstOrFail();
    }
}
