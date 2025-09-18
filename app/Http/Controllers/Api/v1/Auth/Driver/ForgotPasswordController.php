<?php

namespace App\Http\Controllers\Api\v1\Auth\Driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Driver;
use App\Notifications\Auth\DriverResetPasswordNotification;
class ForgotPasswordController extends Controller
{
  
  public function sendOtp(Request $request)
  {
      $request->validate([
          'email' => 'required|email|exists:drivers,email',
      ]);

      $otp = rand(100000, 999999);

      DB::table('driver_password_resets')->updateOrInsert(
          ['email' => $request->email],
          [
              'otp' => $otp,
              'created_at' => now(),
          ]
      );

      $driver = Driver::where('email', $request->email)->first();
      $driver->notify(new DriverResetPasswordNotification($otp));

      return response()->json([
          'success' => true,
          'message' => 'OTP sent to your email address.',
      ]);
  }
}
