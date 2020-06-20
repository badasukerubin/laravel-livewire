<?php

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

Route::livewire('/', 'index')->name('index');

/**
 * Authentication routes
 */
Route::group(['middleware' => ['guest']], function () {
    Route::livewire('/login', 'auth.login')->name('login');
    Route::livewire('/register', 'auth.register')->name('register');
    // Route::livewire('/password/reset', 'auth.passwords.email')->name('password.request');
    // Route::livewire('/password/reset/{token}', 'auth.passwords.reset')->name('password.reset');
    // Route::post('/password/reset', 'Auth\ForgotPasswordController@reset')->name('password.update');
});

/**
 * Verification  routes
 *
 */
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['throttle:6,1']], function () {
        Route::livewire('/email/verify', 'auth.verify')->name('verification.notice');
        Route::group(['middleware' => ['signed']], function () {
            Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
        });
    });
});

/**
 * User routes
 */
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::livewire('/home', 'home')->name('home');
    Route::livewire('/logout', 'auth.logout')->name('logout');
});
