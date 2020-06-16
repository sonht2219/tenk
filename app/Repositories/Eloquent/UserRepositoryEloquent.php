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

    public function findByPhoneNumberOrFails(string $phone_number): User
    {
        return $this->model
            ->where('phone_number', $phone_number)
            ->firstOrFail();
    }

    public function existPhoneNumber($phone_number): bool
    {
        return $this->model
            ->where('phone_number', $phone_number)
            ->exists();
    }
}
