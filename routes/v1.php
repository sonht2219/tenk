<?php
Route::group(['middleware' => 'auth:jwt'], function () {
    Route::group(['prefix' => 'lottery-sessions'], function () {
        Route::get('{id}', 'Api\LotterySessionController@single');
        Route::get('{id}/lotteries', 'Api\LotteryController@listLotteries');
        Route::post('buy-lottery', 'Api\LotteryController@buyLottery');
    });
});
