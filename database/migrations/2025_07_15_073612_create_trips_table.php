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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['in_progress', 'completed', 'cancelled'])->default("in_progress");
            $table->date('departure_date');
            $table->time('departure_time');
            $table->string('origin');
            $table->string('destination');
            $table->string('route');
            $table->decimal('passenger_price', 8, 2);
            $table->integer('max_passengers');
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->foreignId('driver_id')->constrained('drivers');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
