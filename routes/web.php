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
   Route::get('guide-join', function () {
       return view('web-views.guide-join');
   });
   Route::get('articles/{slug}', 'Share\WebViewController@article')->name('article_webview');
});
Route::get('/home', 'HomeController@index')->name('home');
