<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('programacion_juez', function (Blueprint $table) {
            $table->id();

            // Relación con la tabla encuentros
            $table->foreignId('encuentros_id')
                  ->constrained('encuentros')
                  ->onDelete('cascade');

           
            $table->string('nombre');
            $table->string('numero_de_contacto');
            $table->string('sede');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programacion_juez');
    }
};
