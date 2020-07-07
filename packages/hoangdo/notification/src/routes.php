<?php

use HoangDo\Notification\Controller\AdminController;
use HoangDo\Notification\Controller\ApiController;

Route::group(['prefix' => 'api/admin/notifications', 'middleware' => [
    'api',
    'auth:jwt',
    'has_any_roles:ROLE_CAN_MANAGE_NOTIFICATIONS'
]], function () {
    Route::post('', AdminController::class . '@create');
});

Route::group(['prefix' => 'api/v1/notifications', 'middleware' => ['api', 'auth:jwt']], function () {
    Route::get('', ApiController::class . '@list');
    Route::patch('{id}', ApiController::class . '@read');
});
