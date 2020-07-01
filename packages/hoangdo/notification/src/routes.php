<?php

use HoangDo\Notification\Controller\AdminController;
use HoangDo\Notification\Controller\ApiController;

Route::group(['prefix' => 'api/admin/notifications', 'middleware' => ['api', 'auth:jwt']], function () {
    Route::post('', AdminController::class . '@create');
});

Route::group(['prefix' => 'api/v1/notifications', 'middleware' => ['api', 'auth:jwt']], function () {
    Route::get('', ApiController::class . '@list');
    Route::patch('{id}', ApiController::class . '@read');
});
