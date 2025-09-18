<?php

namespace App\Http\Controllers\Api\v1\Auth\Driver;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\Auth\DriverResetPasswordNotification;

class EmailVerificationController extends Controller
{
  public function verify(Request $request)
  {
      $request->validate([
          'email' => 'required|email|exists:drivers,email',
          'otp'   => 'required|digits:6',
      ]);

      $record = DB::table('driver_email_verifications')
          ->where('email', $request->email)
          ->where('otp', $request->otp)
          ->first();

      if (! $record) {
          return response()->json(['success' => false, 'message' => 'Invalid OTP.'], 422);
      }

      $driver = Driver::where('email', $request->email)->first();
      $driver->update(['email_verified_at' => now()]);

      DB::table('driver_email_verifications')->where('email', $request->email)->delete();

      return response()->json(['success' => true, 'message' => 'Email verified successfully.']);
  }

  public function sendOtp(Request $request)
  {
      $request->validate(['email' => 'required|email|exists:drivers,email']);

      $otp = rand(100000, 999999);

      DB::table('driver_email_verifications')->updateOrInsert(
          ['email' => $request->email],
          ['otp' => $otp, 'created_at' => now()]
      );

      $driver = Driver::where('email', $request->email)->first();
      $driver->notify(new DriverResetPasswordNotification($otp));

      return response()->json([
          'success' => true,
          'message' => 'OTP sent to your email.',
      ]);
  }
}
