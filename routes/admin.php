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

    Route::group(['prefix' => 'statistics'], function () {
        Route::get('users-count', 'Admin\DashboardController@usersCount');
        Route::get('products-count', 'Admin\DashboardController@productsCount');
        Route::get('lotteries-count', 'Admin\DashboardController@lotteriesCount');
        Route::get('sessions-count', 'Admin\DashboardController@sessionsCount');
    });

    Route::group(['prefix' => 'articles'], function () {
        Route::post('', 'Admin\ArticleController@create');
        Route::get('', 'Admin\ArticleController@list');
        Route::get('{id}', 'Admin\ArticleController@single');
        Route::put('{id}', 'Admin\ArticleController@edit');
        Route::delete('{id}', 'Admin\ArticleController@delete');
    });
});
