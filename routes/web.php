<?php

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

Route::get('/', 'Auth\LoginController@showLoginForm');

Route::group(['prefix' => 'account'], function () {
    Auth::routes(['register' => false]);
});


Route::group(['middleware' => 'auth'], function () {
    // users
    Route::group(['prefix' => 'member', 'as' => 'member.'], function () {
        Route::resource('/', 'User\UserController');
        Route::get('department/{departmentId}', 'User\UserController@index');
    });
});
