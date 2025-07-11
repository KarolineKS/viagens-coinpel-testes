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
            $table->string('identification_name');
            $table->string('prefix')->unique();
            $table->string('license_plate')->unique();
            $table->string('model');
            $table->string('chassis')->unique();
            $table->string('vehicle_type');
            $table->integer('capacity');
            $table->year('year');
            $table->string('seating_layout');
            $table->boolean('has_internet')->default(false);
            $table->boolean('has_wc')->default(false);
            $table->boolean('has_power_outlet')->default(false);
            $table->boolean('has_ac')->default(false);
            $table->boolean('has_fridge')->default(false);
            $table->boolean('has_heating')->default(false);
            $table->boolean('has_video')->default(false);
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
