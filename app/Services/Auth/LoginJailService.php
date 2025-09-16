<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Cache;

class LoginJailService
{
  protected int $maxFails = 5;
  protected int $jailSeconds = 600;
  public function isJailed(string $phoneNumber): bool
  {
    return Cache::has($this->jailKey($phoneNumber));
  }

  public function recordFailedAttempt(string $phoneNumber): void
  {
    $failsKey = $this->failsKey($phoneNumber);
    $fails = Cache::increment($failsKey);

    Cache::put($failsKey, $fails, $this->jailSeconds);

    if ($fails >= $this->maxFails) {
      Cache::put($this->jailKey($phoneNumber), true, $this->jailSeconds);
    }
  }

  public function clearFails(string $phoneNumber): void
  {
    Cache::forget($this->failsKey($phoneNumber));
    Cache::forget($this->jailKey($phoneNumber));
  }

  private function jailKey(string $phoneNumber): string
  {
    return "jail:{$phoneNumber}";
  }

  private function failsKey(string $phoneNumber): string
  {
    return "fails:{$phoneNumber}";
  }
}
