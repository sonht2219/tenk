<?php

Route::group([
    'prefix' => 'sessions'
], function () {
    Route::get('', 'Api\LotterySessionController@sellingSessions');
    Route::get('count-downing', 'Api\LotterySessionController@countDowningSessions');
});
