<?php

use App\Enum\Type\Role;

Route::group(['middleware' => 'auth:jwt'], function() {
    Route::group(['prefix' => 'products'], function () {
        Route::get('', 'Admin\ProductController@list');
        Route::group(['middleware' => 'has_any_roles:' . Role::CAN_MANAGE_PRODUCTS], function () {
            Route::post('', 'Admin\ProductController@create')->middleware('transaction');
            Route::get('{id}', 'Admin\ProductController@single');
            Route::put('{id}', 'Admin\ProductController@edit');
            Route::delete('{id}', 'Admin\ProductController@delete');
            Route::patch('{id}/bot', 'Admin\ProductController@changeUseBot');
        });
    });

    Route::post('storage', 'Admin\StorageController@saveImage');

    Route::group([
        'prefix' => 'rewards',
        'middleware' => 'has_any_roles:' . Role::CAN_MANAGE_REWARDS
    ], function () {
        Route::get('', 'Admin\LotteryRewardController@list');
        Route::patch('{id}', 'Admin\LotteryRewardController@updateStatus');
    });

    Route::group([
        'prefix' => 'statistics'
    ], function () {
        Route::get('users-count', 'Admin\DashboardController@usersCount');
        Route::get('products-count', 'Admin\DashboardController@productsCount');
        Route::get('lotteries-count', 'Admin\DashboardController@lotteriesCount');
        Route::get('sessions-count', 'Admin\DashboardController@sessionsCount');
        Route::get('revenue', 'Admin\DashboardController@statisticRevenue');
        Route::get('session', 'Admin\DashboardController@statisticSession');
        Route::get('top-user', 'Admin\DashboardController@statisticTopUser');
        Route::get('top-product', 'Admin\DashboardController@statisticTopProduct');
    });

    Route::get('articles', 'Admin\ArticleController@list');
    Route::group([
        'prefix' => 'articles',
        'middleware' => 'has_any_roles:' . Role::CAN_MANAGE_ARTICLES
    ], function () {
        Route::post('', 'Admin\ArticleController@create');
        Route::get('{id}', 'Admin\ArticleController@single');
        Route::put('{id}', 'Admin\ArticleController@edit');
        Route::delete('{id}', 'Admin\ArticleController@delete');
    });

    Route::group([
        'prefix' => 'banner-types',
        'middleware' => 'has_any_roles:' . Role::CAN_MANAGE_BANNERS
    ], function () {
        Route::post('', 'Admin\BannerTypeController@create');
        Route::get('', 'Admin\BannerTypeController@list');
        Route::get('{id}', 'Admin\BannerTypeController@single');
        Route::put('{id}', 'Admin\BannerTypeController@edit');
        Route::delete('{id}', 'Admin\BannerTypeController@delete');
    });

    Route::group([
        'prefix' => 'banners',
        'middleware' => 'has_any_roles:' . Role::CAN_MANAGE_BANNERS
    ], function () {
        Route::post('', 'Admin\BannerController@create');
        Route::get('', 'Share\BannerController@list');
        Route::get('{id}', 'Admin\BannerController@single');
        Route::put('{id}', 'Admin\BannerController@edit');
        Route::delete('{id}', 'Admin\BannerController@delete');
    });

    Route::get('users', 'Admin\UserController@list');
    Route::group([
        'prefix' => 'users',
        'middleware' => 'has_any_roles:' . Role::CAN_MANAGE_USERS
    ], function () {
        Route::post('', 'Admin\UserController@create');
        Route::get('{id}', 'Admin\UserController@single');
        Route::put('{id}', 'Admin\UserController@edit');
        Route::delete('{id}', 'Admin\UserController@delete');
    });

    Route::group([
        'prefix' => 'bots',
        'middleware' => 'has_any_roles:' . Role::CAN_MANAGE_BOTS
    ], function () {
        Route::post('','Admin\BotController@create');
        Route::get('', 'Admin\BotController@list');
        Route::get('{id}', 'Admin\BotController@single');
        Route::put('{id}', 'Admin\BotController@edit');
        Route::delete('{id}', 'Admin\BotController@delete');
    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('', 'Admin\TransactionController@list');
        Route::get('check-phone-card', 'Admin\TransactionController@checkPhoneCard')->middleware('transaction');
        Route::put('{id}', 'Admin\TransactionController@edit')->middleware('transaction');
    });
});
