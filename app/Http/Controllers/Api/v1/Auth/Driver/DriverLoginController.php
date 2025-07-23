<?php

namespace App\Http\Controllers\Api\v1\Auth\Driver;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiTrait as ApiResponse;
use Illuminate\Support\Facades\Hash;

class DriverLoginController extends Controller
{
  use ApiResponse;
  public function login(Request $request)
  {
    $data = $request->validate([
      'phone_number' => ['required', 'string', 'max:20'],
      'password'    => ['required', 'string', 'min:8'],
    ]);
    $driver = Driver::where('phone_number', $data['phone_number'])->first();
    if (!$driver || !Hash::check($data['password'], $driver->password)) {
      return $this->errorMessage(
        ['password' => ['The provided credentials are incorrect.']],
        'Login failed. Please check your credentials.',
      );
    }
    $token = $driver->createToken('driver_token', ['role:driver'])->plainTextToken;
    return $this->successMessage('Login successful', 200, [
      'driver' => $driver->except(['updated_at', 'created_at','password']),
      'token' => $token]);
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();
    return $this->successMessage('Logout successful', 200);
  }
}
