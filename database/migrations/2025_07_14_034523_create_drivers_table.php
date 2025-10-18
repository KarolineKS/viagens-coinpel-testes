<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Creates the `drivers` table with columns for personal, contact, address, and driver's license information.
     *
     * Defines unique constraints and appropriate data types for each field, including support for nullable profile photos and timestamp management.
     */
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->date('birth_date');
            $table->string('registration_number')->unique();
            $table->string('cpf', 14)->unique();
            $table->string('rg', 20);

            $table->string('zip_code', 9);
            $table->string('street');
            $table->string('number', 10);
            $table->string('city');
            $table->string('state', 2);


            $table->string('email')->unique();
            $table->string('phone', 20);


            $table->enum('cnh_category', ['A', 'B', 'C', 'D', 'E', 'AB', 'AC', 'AD', 'AE']);
            $table->string('cnh_number')->unique();
            $table->date('cnh_expiry_date');


            $table->string('profile_photo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Drops the `drivers` table from the database if it exists, reversing the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
