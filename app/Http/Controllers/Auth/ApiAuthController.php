<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Service\Contract\AuthService;
use App\Service\Contract\DtoBuilderService;

class ApiAuthController extends Controller
{
    use AuthorizedController;

    private AuthService $authService;
    private DtoBuilderService $dtoBuilder;
    public function __construct(AuthService $authService, DtoBuilderService $dtoBuilder)
    {
        $this->authService = $authService;
        $this->dtoBuilder = $dtoBuilder;
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
}
