<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programacion_encuentros', function (Blueprint $table) {
            $table->id(); // Esto crea un BIGINT UNSIGNED autoincremental
            $table->string('local');
            $table->string('visitante');
            $table->timestamps();
            
            // Añade esto si necesitas relaciones adicionales
            $table->engine = 'InnoDB'; // Asegura el motor correcto
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programacion_encuentros');
    }
};
