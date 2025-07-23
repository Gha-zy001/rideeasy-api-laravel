<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriverAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function driver_can_register_successfully()
    {
        $payload = [
            'national_id' => '12345678901234',
            'first_name' => 'Mohamed',
            'last_name' => 'Ahmed',
            'email' => 'mohamed@example.com',
            'phone_number' => '01234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
            'license_number' => 'ABC123',
            'vehicle_type' => 'car',
            'vehicle_registration_number' => 'XYZ-1234',
            'status'  => 'active',
            'is_active' => true
        ];

        $response = $this->postJson('/api/v1/driver/register', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Driver registered successfully',
        ]);

        $this->assertDatabaseHas('drivers', [
            'email' => 'mohamed@example.com',
            'national_id' => '12345678901234',
        ]);
    }

    /** @test */
    public function registration_requires_validation()
    {
        $response = $this->postJson('/api/driver/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'national_id',
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'password',
            'license_number',
            'vehicle_type',
            'vehicle_registration_number',
        ]);
    }
}
