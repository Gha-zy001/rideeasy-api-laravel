<?php

namespace App\Http\Controllers\Api\v1\Auth\Driver;

use App\Models\Driver;
use App\Traits\ApiTrait as ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\Http\Requests\Api\Auth\Driver\RegisterRequest;

class DriverRegisterController extends Controller
{
  use ApiResponse;
  public function register(Request $request)
  {
    try {
      $data = $request->validate([
        'national_id' => ['required', 'digits:14', 'unique:drivers,national_id'],
        'first_name' => ['required', 'string', 'max:50'],
        'last_name' => ['required', 'string', 'max:50'],
        'email' => ['required', 'email', 'max:100', 'unique:drivers,email'],
        'phone_number' => ['required', 'string', 'max:20', 'unique:drivers,phone_number'],
        'password'    => ['required', 'string', 'min:8', 'confirmed'],
        'license_number'    => ['required', 'string', 'max:50', 'unique:drivers,license_number'],
        'vehicle_type'        => ['required', 'string'],
        'vehicle_registration_number' => ['required', 'string', 'unique:drivers,vehicle_registration_number'],
      ]);
      $driver = Driver::create($data);
      return $this->successMessage('Driver registered successfully', 201);
    } catch (Exception $e) {
      return $this->errorMessage(
        ['exception' => [$e->getMessage()]],
        'Registration failed. Please try again later.',
        500
      );
    }
  }
}
