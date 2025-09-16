<?php

namespace App\Http\Controllers\Api\v1\Auth\Driver;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiTrait as ApiResponse;
use Illuminate\Support\Facades\Hash;
use App\Services\Auth\LoginRateLimiter;
use App\Services\Auth\LoginJailService;

class DriverLoginController extends Controller
{
  use ApiResponse;

  public function __construct(
    private LoginRateLimiter $limiter,
    private LoginJailService $jail
  ) {}
  public function login(Request $request)
  {
    $data = $request->validate([
      'phone_number' => ['required', 'string', 'max:20'],
      'password'    => ['required', 'string', 'min:8'],
    ]);

    $phone = $data['phone_number'];
    if ($this->jail->isJailed($phone)) {
      return $this->errorMessage(
        ['phone_number' => ['Account temporarily locked. Try again later.']],
        'Too many failed attempts.'
      );
    }

    $this->limiter->ensureIsNotRateLimited($phone);

    $driver = Driver::where('phone_number', $phone)->first();

    if (!$driver || !Hash::check($data['password'], $driver->password)) {
      $this->limiter->hit($phone);
      $this->jail->recordFailedAttempt($phone);

      return $this->errorMessage(
        ['password' => ['The provided credentials are incorrect.']],
        'Login failed.'
      );
    }
    $this->limiter->clear($phone);
    $this->jail->clearFails($phone);
    $token = $driver->createToken('driver_token', ['role:driver']);
    $token->accessToken->update([
      'expires_at' => now()->addHours(2)
  ]);
    return $this->successMessage('Login successful', 200, [
      'driver' => $driver->makeHidden(['updated_at', 'created_at', 'password']),
      'token' => $token->plainTextToken
    ]);
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();
    return $this->successMessage('Logout successful', 200);
  }
}
