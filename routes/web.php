<?php

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'verify' => true,
    'register' => false
]);
Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'web-views'], function () {
    Route::view('vue/{any}', 'layouts.vue')->where('any', '.*');
    Route::view('guide-join', 'web-views.guide-join');
    Route::view('payment', 'web-views.payment');
});
Route::get('/home', 'HomeController@index')->name('home');
