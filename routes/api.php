<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'admin', 'middleware' => 'json'], function () {
   require_once __DIR__ . '/admin.php';
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\ApiAuthController@login');
    Route::post('register', 'Auth\ApiAuthController@register');
    Route::get('user-data', 'Auth\ApiAuthController@userData');
});
