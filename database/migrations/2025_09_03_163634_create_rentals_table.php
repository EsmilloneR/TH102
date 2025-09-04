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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->dateTime('rental_start');
            $table->dateTime('rental_end');

            $table->string('pickup_location')->nullable();
            $table->string('dropoff_location')->nullable();
            $table->enum('trip_type', ['pickup_dropoff', 'hrs', 'roundtrip', '24hrs', 'days', 'week', 'month']); // ['pickup_drop', 'hours', 'round_trip', '24h', 'days', 'weeks']

            $table->unsignedTinyInteger('fuel_level_out')->nullable();
            $table->unsignedTinyInteger('fuel_level_in')->nullable();

            $table->decimal('base_amount',10,2)->default(0);
            $table->decimal('deposit', 10,2)->default(0);
            $table->decimal('extra_charges', 10,2)->default(0);
            $table->decimal('penalties',10,2)->default(0);

            $table->enum('status', ['reserved', 'ongoing', 'completed', 'cancelled'])->default('reserved');
            $table->string('agreement_no')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
