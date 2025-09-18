<?php

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\Driver\DriverLoginController;
use App\Http\Controllers\Api\v1\Auth\Driver\ResetPasswordController;
use App\Http\Controllers\Api\v1\Auth\Driver\DriverRegisterController;
use App\Http\Controllers\Api\v1\Auth\Driver\EmailVerificationController;
use App\Http\Controllers\Api\v1\Auth\Driver\ForgotPasswordController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1/driver')->group(function () {
  Route::post('/register', [DriverRegisterController::class, 'register']);
  Route::post('/login', [DriverLoginController::class, 'login']);
  Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp']);
  Route::post('/verify-otp', [ResetPasswordController::class, 'verifyOtp']);
  Route::post('/reset-password', [ResetPasswordController::class, 'resetWithOtp']);
  Route::middleware(['auth:driver', 'check.token.expiry', 'throttle:60,1'])->group(function () {
    Route::post('/logout', [DriverLoginController::class, 'logout']);
  });
});
