<?php

Route::group([
    'prefix' => 'sessions'
], function () {
    Route::get('', 'Api\LotterySessionController@sellingSessions');
    Route::get('count-downing', 'Api\LotterySessionController@countDowningSessions');
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
    Route::get('list-by-user', 'Api\LotteryController@allLotteriesOfUserInSession');
});
