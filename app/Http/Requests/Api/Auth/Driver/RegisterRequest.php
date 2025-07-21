<?php

namespace App\Http\Requests\Api\Auth\Driver;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'national_id'                => ['required', 'digits:14', 'unique:drivers,national_id'],
      'first_name'                 => ['required', 'string', 'max:50'],
      'last_name'                  => ['required', 'string', 'max:50'],
      'email'                      => ['required', 'email', 'max:100', 'unique:drivers,email'],
      'phone_number'              => ['required', 'string', 'max:20', 'unique:drivers,phone_number'],
      'password'                   => ['required', 'string', 'min:8', 'confirmed'],
      'license_number'             => ['required', 'string', 'max:50', 'unique:drivers,license_number'],
      'vehicle_type'               => ['required', 'string'],
      'vehicle_registration_number' => ['required', 'string', 'unique:drivers,vehicle_registration_number'],
    ];
  }
}
