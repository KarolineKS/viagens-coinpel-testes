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
            $table->string('prefixo')->unique();
            $table->string('placa')->unique();
            $table->string('modelo');
            $table->string('chassi')->unique();
            $table->string('tipo_veiculo');
            $table->integer('capacidade');
            $table->year('ano');
            $table->string('bancada');
            $table->boolean('internet')->default(false);
            $table->boolean('wc')->default(false);
            $table->boolean('tomada')->default(false);
            $table->boolean('ar_condicionado')->default(false);
            $table->boolean('geladeira')->default(false);
            $table->boolean('calefacao')->default(false);
            $table->boolean('video')->default(false);
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
