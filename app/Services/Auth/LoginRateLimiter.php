<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRateLimiter
{
  protected int $maxAttempts = 5;
  protected int $decaySeconds = 60;

  public function ensureIsNotRateLimited(string $phoneNumber)
  {
    $key = $this->throttleKey($phoneNumber);

    if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
      $seconds = RateLimiter::availableIn($key);

      throw ValidationException::withMessages([
        'phone_number' => ["Too many attempts. Try again in {$seconds} seconds."],
      ]);
    }
  }

  public function hit(string $phoneNumber)
  {
    RateLimiter::hit($this->throttleKey($phoneNumber), $this->decaySeconds);
  }

  public function clear(string $phoneNumber)
  {
    RateLimiter::clear($this->throttleKey($phoneNumber));
  }

  protected function throttleKey(string $phoneNumber): string
  {
    return Str::lower("login:{$phoneNumber}");
  }
}
