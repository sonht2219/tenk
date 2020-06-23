<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddressCreateRequest;
use App\Http\Requests\UserAddressEditRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\UserAddressService;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    use AuthorizedController;

    private UserAddressService $userAddressService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(UserAddressService $userAddressService, DtoBuilderService $dtoBuilder)
    {
        $this->userAddressService = $userAddressService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function createAddress(UserAddressCreateRequest $req) {
        return $this->dtoBuilder->buildUserAddressDto($this->userAddressService->create($this->user(), $req));
    }

    public function editAddress($id, UserAddressEditRequest $req) {
        return $this->dtoBuilder->buildUserAddressDto($this->userAddressService->edit($id, $this->user(), $req));
    }

    public function deleteAddress($id) {
        return $this->dtoBuilder->buildUserAddressDto($this->userAddressService->delete($id, $this->user()));
    }

    public function singleAddress($id) {
        return $this->dtoBuilder->buildUserAddressDto($this->userAddressService->single($id, $this->user()));
    }

    public function singleAddressDefault() {
        return $this->dtoBuilder->buildUserAddressDto($this->userAddressService->singleDefault($this->user()));
    }

    public function listAddress(Request $req) {
        return $this->userAddressService->list($this->user(), $req)->map(fn($address) => $this->dtoBuilder->buildUserAddressDto($address));
    }
}
