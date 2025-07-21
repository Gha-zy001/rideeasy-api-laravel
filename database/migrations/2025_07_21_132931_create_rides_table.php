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
        Schema::create('rides', function (Blueprint $table) {
            $table->id('ride_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('passenger_id');
            $table->decimal('pickup_latitude', 9, 6);
            $table->decimal('pickup_longitude', 9, 6);
            $table->decimal('dropoff_latitude', 9, 6);
            $table->decimal('dropoff_longitude', 9, 6);

            $table->string('pickup_address')->nullable();
            $table->string('dropoff_address')->nullable();

            $table->timestamp('request_time')->useCurrent();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();

            $table->decimal('estimated_fare', 10, 2)->nullable();
            $table->decimal('actual_fare', 10, 2)->nullable();

            $table->string('ride_status');
            $table->decimal('distance', 10, 2)->nullable(); //KM

            $table->unsignedBigInteger('payment_id')->nullable();

            $table->timestamps();

            $table->foreign('driver_id')->references('national_id')->on('drivers');
            $table->foreign('passenger_id')->references('national_id')->on('passengers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
