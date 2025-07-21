<?php

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\Driver\DriverRegisterController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::prefix('driver')->group(function () {
  Route::post('/register', [DriverRegisterController::class, 'register']);
});
