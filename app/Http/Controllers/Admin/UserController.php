<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(UserService $userService, DtoBuilderService $dtoBuilder)
    {
        $this->userService = $userService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function create(UserRequest $req) {
        return $this->dtoBuilder->buildUserDto($this->userService->createUser($req));
    }
    public function list(Request $req) {
        $users = $this->userService->listUser($req);
        return [
            'datas' => collect($users->items())->map(fn($user) => $this->dtoBuilder->buildUserDto($user)),
            'meta' => get_meta($users)
        ];
    }
    public function single($id) {
        return $this->dtoBuilder->buildUserDto($this->userService->singleUser($id));
    }
    public function edit($id, UserRequest $req) {
        return $this->dtoBuilder->buildUserDto($this->userService->editUser($id, $req));
    }
    public function delete($id) {
        return $this->dtoBuilder->buildUserDto($this->userService->deleteUser($id));
    }
}
