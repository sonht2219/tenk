<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Exceptions\ExecuteException;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Contract\UserRepository;
use App\Service\Contract\AuthService;
use App\Service\Traits\GenerateIdUserTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\JWT;
use Illuminate\Support\Facades\Hash;

class AuthServiceImpl implements AuthService
{
    use GenerateIdUserTrait;

    private UserRepository $userRepo;

    private JWT $jwt;

    private $password_broker;

    public function __construct(UserRepository $userRepo, JWT $jwt)
    {
        $this->userRepo = $userRepo;
        $this->jwt = $jwt;
        $this->setUserRepositoryForGenerateId($userRepo);
        $this->password_broker = Password::broker();
    }

    /**
     * @inheritDoc
     */
    public function register(RegisterRequest $req)
    {
        try {
            $data = $req->filteredData();
            $data['password'] = Hash::make($req->password);
            $data['id'] = $this->generateId();

            $user = $this->userRepo->create($data);
            event(new Registered($user));
            return $user;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function login(AuthRequest $req)
    {
        $user = $this->userRepo->findByPhoneNumberOrFails($req->phone_number);
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

    public function changePassword(ChangePasswordRequest $req, User $user)
    {
        if ($user->getAuthPassword() && !\Hash::check($req->get('old_password'), $user->getAuthPassword()))
            throw new ExecuteException(__('Mật khẩu cũ không chính xác'));

        $user->password = \Hash::make($req->get('password'));
        return $this->userRepo->save($user);
    }

    public function forgetPassword(ForgetPasswordRequest $req)
    {
        $response = $this->password_broker->sendResetLink($req->only('email'));
        if ($response != Password::RESET_LINK_SENT)
            throw new ExecuteException(__('Đã xảy ra lỗi. Vui lòng thử lại sau'));

        return null;
    }
}
