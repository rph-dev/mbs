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
    Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
        Route::resource('member', 'User\UserController');
        Route::get('department/{departmentId}', 'User\UserController@index');
    });

    // BMS
    Route::group(['prefix' => 'mbs', 'as' => 'mbs.'], function () {
        // Home
        Route::get('/', ['as' => 'home.index', 'uses' => 'Mbs\HomeController@index']);
        Route::get('/init-contact', 'Mbs\HomeController@initContact');
        Route::get('/init-history-contact', 'Mbs\HomeController@initHistoryContact');
        Route::get('/load-message', 'Mbs\HomeController@loadMessage');
        Route::post('/load-contact', 'Mbs\HomeController@loadContact');
        Route::post('store', 'Mbs\HomeController@store');
        Route::resource('group-custom', 'Mbs\CustomGroupController');
        Route::resource('user-custom', 'Mbs\CustomUserController');
    });
});
