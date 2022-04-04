<?php

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

Route::middleware('guest')->post('/register', \App\Http\Controllers\UserRegistrationController::class);

Route::middleware('guest')->post('/login', \App\Http\Controllers\UserLoginController::class);

Route::middleware('auth:sanctum')->post('/logout', \App\Http\Controllers\UserLogOutController::class);

Route::get('/email/verify/{id}/{hash}',\App\Http\Controllers\VerifyEmailController::class);

Route::post('/email/verification-notification',\App\Http\Controllers\ResendVerificationLinkController::class);

Route::group(['middleware' => ['role:doctor']], function () {
});

Route::group(['middleware' => ['role:patient']], function () {
});
