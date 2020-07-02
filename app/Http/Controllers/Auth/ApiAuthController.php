<?php


namespace App\Http\Controllers\Auth;


use App\Helper\Constant;
use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Service\Contract\AuthService;
use App\Service\Contract\DtoBuilderService;
use HoangDo\Notification\Service\NotifyService;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    use AuthorizedController;

    private AuthService $authService;
    private DtoBuilderService $dtoBuilder;
    private NotifyService $notifyService;

    public function __construct(AuthService $authService, DtoBuilderService $dtoBuilder, NotifyService $notifyService)
    {
        $this->authService = $authService;
        $this->dtoBuilder = $dtoBuilder;
        $this->notifyService = $notifyService;
    }

    public function register(RegisterRequest $req) {
        $user = $this->authService->register($req);
        return [
            'user' => $this->dtoBuilder->buildUserDto($user),
            'token' => $this->authService->generateToken($user)
        ];
    }

    public function login(AuthRequest $req) {
        $user = $this->authService->login($req);
        return [
            'user' => $this->dtoBuilder->buildUserDto($user),
            'token' => $this->authService->generateToken($user)
        ];
    }

    public function userData() {
        return [
            'user' => $this->dtoBuilder->buildUserDto($this->user()),
            'token' => $this->authService->generateToken($this->user())
        ];
    }

    public function changePassword(ChangePasswordRequest $req) {
        return $this->dtoBuilder->buildUserDto($this->authService->changePassword($req, $this->user()));
    }

    public function forgetPassword(ForgetPasswordRequest $req) {
        return $this->authService->forgetPassword($req);
    }

    public function logout(Request $req) {
        $app_token = $req->header(config('notification.token_header'));
        $this->notifyService->removeAppToken($app_token);
        return ['data' => null];
    }
}
