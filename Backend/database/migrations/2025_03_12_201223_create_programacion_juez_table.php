<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('programacion_juez', function (Blueprint $table) {
            $table->id();

            // RELACIÓN CORRECTA CON LA TABLA encuentros
            $table->foreignId('encuentros_id')  // esto crea unsignedBigInteger + foreign key automáticamente
                  ->constrained('encuentros')   // nombre exacto de la tabla referenciada
                  ->onDelete('cascade');        // para eliminar en cascada

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programacion_juez');
    }
};
