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

Route::get('/email/verify/{id}/{hash}', \App\Http\Controllers\VerifyEmailController::class)->name('verification.verify');

Route::middleware('auth:sanctum')->post('/email/verification-notification', \App\Http\Controllers\ResendVerificationLinkController::class);

Route::group(['middleware' => ['role:doctor']], function () {
    Route::post('/createDoctorInformation', \App\Http\Controllers\CreateDoctorInformationController::class);
    Route::get('/getDoctorInformation', \App\Http\Controllers\GetDoctorInformationController::class);
    Route::patch('/updateDoctorInformation', \App\Http\Controllers\UpdateDoctorInformationController::class);
});

Route::group(['middleware' => ['role:patient']], function () {
    Route::post('/createPatientInformation', \App\Http\Controllers\CreatePatientInformationController::class);
    Route::patch('/updatePatientInformation', \App\Http\Controllers\UpdatePatientInformationController::class);
    Route::get('/getPatientInformation', \App\Http\Controllers\GetPatientInformationController::class);
    Route::post('/createSubmission', \App\Http\Controllers\CreateSubmissionController::class);
    Route::delete('/submissions/{submission}/delete', \App\Http\Controllers\DeleteSubmissionController::class);
});
