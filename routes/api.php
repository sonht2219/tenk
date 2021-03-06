<?php

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'admin', 'middleware' => 'auth:jwt'], function () {
   require_once __DIR__ . '/admin.php';
});

Route::group(['prefix' => 'v1'], function () {
    require_once __DIR__ . '/v1.php';
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\ApiAuthController@login');
    Route::post('register', 'Auth\ApiAuthController@register');
    Route::post('forget-password', 'Auth\ApiAuthController@forgetPassword');
    Route::get('logout', 'Auth\ApiAuthController@logout');
    Route::group(['middleware' => 'auth:jwt'], function () {
        Route::get('user-data', 'Auth\ApiAuthController@userData')->middleware('notify_token');
        Route::post('change-password', 'Auth\ApiAuthController@changePassword');
    });
});

Route::group(['prefix' => 'regions', 'middleware' => 'auth:jwt'], function () {
    Route::get('provinces', 'Share\RegionController@provinces');
    Route::get('provinces/{province_id}/district', 'Share\RegionController@districtOfProvince');
});
