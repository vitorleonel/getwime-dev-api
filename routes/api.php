<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->namespace('Auth')->middleware('guest')->group(function() {
    Route::post('signup', 'SignUpController')->name('auth.signup');
    Route::post('signin', 'SignInController')->name('auth.signin');
});
