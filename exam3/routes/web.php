<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// register
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// logged in
Route::group(['middleware' => ['auth:web']], function () {
    
    Route::get('/accounts', 'HomeController@index')->name('home');

    // account
    Route::get('/accounts/{user}', 'AccountController@show')->name('accounts.show');

    // account api
    Route::group(['prefix' => '/api/user/accounts', 'as' => 'api.user.accounts.'], function() {

        Route::get('/', 'Api\AccountController@index')->name('index');
        Route::post('/', 'Api\AccountController@store')->name('store');
    });

});