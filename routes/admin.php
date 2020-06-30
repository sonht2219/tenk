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

    Route::group(['prefix' => 'banner-types'], function () {
        Route::post('', 'Admin\BannerTypeController@create');
        Route::get('', 'Admin\BannerTypeController@list');
        Route::get('{id}', 'Admin\BannerTypeController@single');
        Route::put('{id}', 'Admin\BannerTypeController@edit');
        Route::delete('{id}', 'Admin\BannerTypeController@delete');
    });

    Route::group(['prefix' => 'banners'], function () {
        Route::post('', 'Admin\BannerController@create');
        Route::get('', 'Share\BannerController@list');
        Route::get('{id}', 'Admin\BannerController@single');
        Route::put('{id}', 'Admin\BannerController@edit');
        Route::delete('{id}', 'Admin\BannerController@delete');
    });
});
