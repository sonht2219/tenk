<?php
Route::group(['middleware' => 'auth:jwt'], function () {
    Route::group(['prefix' => 'lottery-sessions'], function () {
        Route::get('{id}', 'Api\LotterySessionController@single');
        Route::get('{id}/lotteries', 'Api\LotterySessionController@listLotteries');
        Route::post('buy-lottery', 'Api\LotterySessionController@buyLottery');
    });
});
