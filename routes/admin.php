<?php

Route::post('login', 'Auth\ApiAuthController@login');

Route::group(['middleware' => 'auth:jwt'], function() {
    Route::group(['prefix' => 'products'], function () {
        Route::post('', 'Admin\ProductController@create')->middleware('transaction');
        Route::get('{id}', 'Admin\ProductController@single');
        Route::put('{id}', 'Admin\ProductController@edit');
    });
});
