<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;

class ApiAuthController extends Controller
{
    public function login(AuthRequest $req) {
        return [
            'data' => $req->all()
        ];
    }
}
