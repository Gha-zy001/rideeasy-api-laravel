<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
          $table->unsignedBigInteger('national_id')->primary();
          $table->string('first_name');
          $table->string('last_name');
          $table->string('email')->unique();
          $table->string('phone_number')->nullable();
          $table->string('password');
          $table->string('license_number')->unique();
          $table->string('vehicle_type')->nullable();
          $table->string('vehicle_registration_number')->nullable();
          $table->boolean('is_active')->default(false);
          $table->string('status');
          $table->index('email');
          $table->index('license_number');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
