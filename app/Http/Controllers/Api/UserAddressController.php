<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Service\Contract\UserAddressService;

class UserAddressController extends Controller
{
    private UserAddressService $userAddressService;

    public function __construct(UserAddressService $userAddressService)
    {
        $this->userAddressService = $userAddressService;
    }

    public function createAddress() {

    }

    public function editAddress() {

    }

    public function deleteAddress() {

    }

    public function listAddress() {}
}
