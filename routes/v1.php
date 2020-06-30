<?php

Route::group([
    'prefix' => 'sessions'
], function () {
    Route::get('', 'Api\LotterySessionController@sellingSessions');
    Route::get('count-downing', 'Api\LotterySessionController@countDowningSessions');
    Route::get('list-opening-ended', 'Api\LotterySessionController@listSessionOpeningAndEnded');
    Route::get('single-by-product', 'Api\LotterySessionController@singleByProductAndStatus');
    Route::get('history-mine', 'Api\LotterySessionController@historyMine')->middleware('auth:jwt');
    Route::get('{id}', 'Api\LotterySessionController@single');
    Route::get('{id}/history', 'Api\LotterySessionController@historyLotterySession');
    Route::group(['prefix' => '', 'middleware' => 'auth:jwt'], function () {
        Route::get('{id}/lotteries', 'Api\LotteryController@listLotteries');
        Route::post('buy-lottery', 'Api\LotteryController@buyLotteries')->middleware('transaction');
    });
});

Route::group([
    'prefix' => 'feedback'
], function () {
    Route::get('', 'Api\FeedbackController@list');
    Route::group(['middleware' => 'auth:jwt'], function () {
        Route::get('mine', 'Api\FeedbackController@myFeedback');
        Route::post('', 'Api\FeedbackController@create');
    });
});

Route::group(['prefix' => 'lotteries'], function () {
    Route::get('detail-history-buy', 'Api\LotteryController@detailHistoryBuyLottery');
});

Route::group(['prefix' => 'rewards'], function () {
   Route::get('product/{product_id}', 'Api\LotteryRewardController@listRewardOfProduct') ;
   Route::group(['middleware' => 'auth:jwt'], function () {
       Route::get('history', 'Api\LotteryRewardController@history');
       Route::post('receive', 'Api\LotteryRewardController@receiveReward')->middleware('transaction');
   });
});

Route::group(['prefix' => 'user-addresses', 'middleware' => 'auth:jwt'], function () {
   Route::post('', 'Api\UserAddressController@createAddress');
   Route::get('', 'Api\UserAddressController@listAddress');
   Route::get('single-default', 'Api\UserAddressController@singleAddressDefault');
   Route::get('{id}', 'Api\UserAddressController@singleAddress');
   Route::put('{id}', 'Api\UserAddressController@editAddress');
   Route::delete('{id}', 'Api\UserAddressController@deleteAddress');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:jwt'], function () {
    Route::get('wallet', 'Api\UserController@wallet');
    Route::post('update-profile', 'Api\UserController@updateProfile');
});


Route::group(['prefix' => 'banners'], function () {
    Route::get('', 'Share\BannerController@list');
});
