<?php
/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 1/1/20
 * Time: 11:26 AM
 */

namespace App\Http\Controllers;


use Tymon\JWTAuth\JWTAuth;

trait AuthorizedController
{
    protected function user() {
        $user = request()->user();
        if (!$user) {
            try {
                /** @var JWTAuth $jwtAuth */
                $jwtAuth = app(JWTAuth::class);
                $user = $jwtAuth->setToken(request()->bearerToken())->toUser();
            } catch (\Exception $exception) {
            }
        }
        return $user;
    }
}
