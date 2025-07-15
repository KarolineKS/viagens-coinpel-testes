<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds soft delete support to the 'drivers' table by introducing a nullable 'deleted_at' timestamp column.
     */
    public function up(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Removes the soft delete functionality from the 'drivers' table by dropping the 'deleted_at' column.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
