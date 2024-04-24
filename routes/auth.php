<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\CreateProfileController;
use App\Http\Controllers\Api\V1\Auth\LoginWithAdditionalPassword;
use App\Http\Controllers\Api\V1\Auth\PhoneVerificationController;

Route::prefix('auth')->group(function () {
    Route::post('/verification-code/request', [PhoneVerificationController::class, 'requestVerificationCode']);
    Route::post('/verify-code', [PhoneVerificationController::class, 'verifyCode']);
    Route::post('/create-profile', CreateProfileController::class);
    Route::post('/login/additional-password', LoginWithAdditionalPassword::class);
    Route::post('/logout', [AuthenticationController::class,"logout"]);
    Route::post('/token/refresh', [AuthenticationController::class,"refresh"]);
});
