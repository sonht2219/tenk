<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Exceptions\ExecuteException;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Contract\UserRepository;
use App\Service\Contract\AuthService;
use App\Services\Traits\GenerateIdUserTrait;
use App\User;
use Carbon\Carbon;
use Tymon\JWTAuth\JWT;

class AuthServiceImpl implements AuthService
{
    use GenerateIdUserTrait;

    private UserRepository $userRepo;

    private JWT $jwt;

    public function __construct(UserRepository $userRepo, JWT $jwt)
    {
        $this->userRepo = $userRepo;
        $this->jwt = $jwt;
        $this->setUserRepositoryForGenerateId($userRepo);
    }

    /**
     * @inheritDoc
     */
    public function register(RegisterRequest $req)
    {
        $data = $req->filteredData();
        $data['password'] = Hash::make($req->password);
        $data['birthday'] = $req->birthday ? Carbon::createFromTimestampMs($req->birthday) : null;
        $data['id'] = $this->generateId();
        return $this->userRepo->create($data);
    }

    /**
     * @inheritDoc
     */
    public function login(AuthRequest $req)
    {
        $user = $this->userRepo->findByEmailOrFails($req->email);
        if (!Hash::check($req->password, $user->password))
            throw new ExecuteException(__('messages.password_not_match'));
        if ($user->status != CommonStatus::ACTIVE)
            throw new ExecuteException(__('Tài khoản của bạn đã bị khóa'));
        return $user;

    }

    /**
     * @inheritDoc
     */
    public function generateToken(User $user)
    {
        return $this->jwt->fromUser($user);
    }
}
