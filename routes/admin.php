<?php

Route::group(['middleware' => 'auth:jwt'], function() {
    Route::group(['prefix' => 'products'], function () {
        Route::post('', 'Admin\ProductController@create')->middleware('transaction');
        Route::get('', 'Admin\ProductController@list');
        Route::get('{id}', 'Admin\ProductController@single');
        Route::put('{id}', 'Admin\ProductController@edit');
        Route::delete('{id}', 'Admin\ProductController@delete');
    });

    Route::post('storage', 'Admin\StorageController@saveImage');

    Route::group(['prefix' => 'rewards'], function () {
        Route::get('', 'Admin\LotteryRewardController@list');
        Route::patch('{id}', 'Admin\LotteryRewardController@updateStatus');
    });
});
