<?php


namespace App\Service\Contract;


use App\Exceptions\ExecuteException;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\User;

interface AuthService
{
    /**
     * @param RegisterRequest $req
     * @return User
     * @throws ExecuteException
     */
    public function register(RegisterRequest $req);

    /**
     * @param AuthRequest $req
     * @return User
     * @throws ExecuteException
     */
    public function login(AuthRequest $req);

    /**
     * @param User $user
     * @return string
     */
    public function generateToken(User $user);
}
