<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::post('/subscribe', 'Auth\SubscriptionController@createSubscription');
    Route::get('/unsubscribe', 'Auth\SubscriptionController@deleteSubscription');
    Route::get('/confirm', 'Auth\SubscriptionController@confirmSubscription');
    Route::get('/resend-confirmation', 'Auth\SubscriptionController@resendConfirmation');
    Route::get('/login', 'Auth\LoginController@home');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('/create-password', 'Auth\PasswordController@home');
    Route::post('/create-password', 'Auth\PasswordController@createPassword');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/settings', 'SettingsController@home');
    Route::post('/settings/difficulties/update', 'SettingsController@updateDifficulties');
    Route::post('/settings/frequency/update', 'SettingsController@updateFrequency');
});