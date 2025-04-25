<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amonestaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_jugador');
            $table->integer('numero_camiseta');
            $table->string('equipo');
            $table->string('encuentro_disputado');
            $table->boolean('tarjeta_roja')->default(false);
            $table->boolean('tarjeta_amarilla')->default(false);
            $table->boolean('tarjeta_azul')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amonestaciones');
    }
};
