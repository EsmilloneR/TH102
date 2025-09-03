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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('model');
            $table->string('year');
            $table->string('licensed_number')->unique();
            $table->string('color')->nullable();
            $table->enum('transmission', ['manual', 'automatic']);
            $table->integer('seats')->default(5);
            $table->decimal('rate_hour', 10,2)->nullable();
            $table->decimal('rate_day', 10,2)->nullable();
            $table->decimal('rate_week', 10,2)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
