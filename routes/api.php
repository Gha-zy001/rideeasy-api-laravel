<?php

use App\Http\Controllers\Api\v1\Auth\Driver\DriverLoginController;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\Driver\DriverRegisterController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1/driver')->group(function () {
  Route::post('/register', [DriverRegisterController::class, 'register']);
  Route::post('/login', [DriverLoginController::class, 'login']);
  Route::middleware('auth:driver')->group(function () {
    Route::post('/logout', [DriverLoginController::class, 'logout']);
  });
});
