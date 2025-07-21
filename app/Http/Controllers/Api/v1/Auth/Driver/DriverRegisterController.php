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
  public function register(RegisterRequest $request)
  {
    try {
      $driver = Driver::create($request->validated());
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
