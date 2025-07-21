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
        Schema::create('ride_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ride_id')->unique();
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('passenger_id');
            $table->tinyInteger('driver_rating')->nullable();
            $table->text('driver_feedback')->nullable();
            $table->tinyInteger('passenger_rating')->nullable();
            $table->text('passenger_feedback')->nullable();
            $table->foreign('ride_id')->references('ride_id')->on('rides')->onDelete('cascade');
            $table->foreign('driver_id')->references('national_id')->on('drivers')->onDelete('cascade');
            $table->foreign('passenger_id')->references('national_id')->on('passengers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_ratings');
    }
};
