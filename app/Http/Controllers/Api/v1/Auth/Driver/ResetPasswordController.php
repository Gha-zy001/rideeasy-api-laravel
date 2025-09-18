<?php

namespace App\Http\Controllers\Api\v1\Auth\Driver;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
  public function verifyOtp(Request $request)
  {
    $request->validate([
      'email' => 'required|email|exists:drivers,email',
      'otp'   => 'required|digits:6',
    ]);

    $record = DB::table('driver_password_resets')
      ->where('email', $request->email)
      ->where('otp', $request->otp)
      ->first();

    if (! $record) {
      return response()->json(['success' => false, 'message' => 'Invalid OTP.'], 422);
    }

    if (now()->diffInMinutes($record->created_at) > 10) {
      return response()->json(['success' => false, 'message' => 'OTP expired.'], 422);
    }

    return response()->json(['success' => true, 'message' => 'OTP verified.']);
  }

  public function resetWithOtp(Request $request)
  {
    $request->validate([
      'email'    => 'required|email|exists:drivers,email',
      'otp'      => 'required|digits:6',
      'password' => 'required|string|min:8|confirmed',
    ]);

    $record = DB::table('driver_password_resets')
      ->where('email', $request->email)
      ->where('otp', $request->otp)
      ->first();

    if (! $record) {
      return response()->json(['success' => false, 'message' => 'Invalid OTP.'], 422);
    }

    $driver = Driver::where('email', $request->email)->first();
    $driver->update(['password' => Hash::make($request->password)]);

    DB::table('driver_password_resets')->where('email', $request->email)->delete();

    return response()->json(['success' => true, 'message' => 'Password reset successfully.']);
  }
}
