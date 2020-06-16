<?php

Route::group([
    'prefix' => 'sessions'
], function () {
    Route::get('', 'Api\LotterySessionController@sellingSessions');
    Route::get('count-downing', 'Api\LotterySessionController@countDowningSessions');
});

Route::group(['middleware' => 'auth:jwt'], function () {
    Route::group(['prefix' => 'lottery-sessions'], function () {
        Route::get('{id}', 'Api\LotterySessionController@single');
        Route::get('{id}/history', 'Api\LotterySessionController@historyLotterySession');
        Route::get('{id}/lotteries', 'Api\LotteryController@listLotteries');
        Route::post('buy-lottery', 'Api\LotteryController@buyLotteries')->middleware('transaction');
    });
    Route::group(['prefix' => 'lotteries'], function () {
        Route::get('list-by-user', 'Api\LotteryController@allLotteriesOfUserInSession');
    });
});
Route::get('test', 'Api\LotteryController@test');
