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
        Schema::create('passengers', function (Blueprint $table) {
          $table->unsignedBigInteger('national_id')->primary();
          $table->string('first_name');
          $table->string('last_name');
          $table->string('email')->unique();
          $table->string('phone_number')->nullable();
          $table->string('password');
          $table->index('email', 'idx_passengers_email');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
