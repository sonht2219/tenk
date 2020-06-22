<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'regions', 'middleware' => 'auth:jwt'], function () {
    Route::get('provinces', 'Share\RegionController@provinces');
    Route::get('provinces/{province_id}/district', 'Share\RegionController@districtOfProvince');
});

Route::group(['prefix' => 'web-views'], function () {
   Route::get('guide-join', function () {
       return view('web-views.guide-join');
   });
});
Route::get('/home', 'HomeController@index')->name('home');
