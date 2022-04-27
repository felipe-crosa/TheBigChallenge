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

Route::get('/email/verify/{id}/{hash}', \App\Http\Controllers\VerifyEmailController::class)->name('verification.verify');

Route::group(['middleware' => 'guest:sanctum'], function () {
    Route::post('/register', \App\Http\Controllers\UserRegistrationController::class);
    Route::post('/login', \App\Http\Controllers\UserLoginController::class);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/email/verification-notification', \App\Http\Controllers\ResendVerificationLinkController::class);
    Route::middleware('auth:sanctum')->post('/logout', \App\Http\Controllers\UserLogOutController::class);
    Route::get('/submissions/{submission}', \App\Http\Controllers\GetSubmissionController::class);
    Route::get('/submissions', \App\Http\Controllers\ListSubmissionsController::class);

    Route::group(['middleware' => ['role:doctor']], function () {
        Route::patch('/submissions/{submission}/assign', \App\Http\Controllers\AssignSubmissionController::class);
        Route::post('/createDoctorInformation', \App\Http\Controllers\CreateDoctorInformationController::class);
        Route::get('/getDoctorInformation', \App\Http\Controllers\GetDoctorInformationController::class);
        Route::patch('/updateDoctorInformation', \App\Http\Controllers\UpdateDoctorInformationController::class);
        Route::post('/submissions/{submission}/diagnose', \App\Http\Controllers\UploadDiagnosisController::class);
        Route::delete('/submissions/{submission}/deleteDiagnosis', \App\Http\Controllers\DeleteDiagnosisController::class);
    });

    Route::group(['middleware' => ['role:patient']], function () {
        Route::post('/createPatientInformation', \App\Http\Controllers\CreatePatientInformationController::class);
        Route::patch('/updatePatientInformation', \App\Http\Controllers\UpdatePatientInformationController::class);
        Route::get('/getPatientInformation', \App\Http\Controllers\GetPatientInformationController::class);
        Route::post('/createSubmission', \App\Http\Controllers\CreateSubmissionController::class);
        Route::delete('/submissions/{submission}/delete', \App\Http\Controllers\DeleteSubmissionController::class);
        Route::patch('/submissions/{submission}/update', \App\Http\Controllers\UpdateSubmissionController::class);
    });
});
