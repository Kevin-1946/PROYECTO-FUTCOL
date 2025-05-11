<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jugador', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'N_documento', 'fecha_nacimiento']);

            $table->string('nombre_jugador', 100)->unique();
            $table->unsignedTinyInteger('numero_camiseta');
            $table->unsignedTinyInteger('edad');
            $table->string('nombre_equipo', 100);
            $table->unsignedTinyInteger('goles_a_favor');
        });
    }

    public function down(): void
    {
        Schema::table('jugador', function (Blueprint $table) {
            $table->dropColumn([
                'nombre_jugador',
                'numero_camiseta',
                'edad',
                'nombre_equipo',
                'goles_a_favor',
            ]);

            $table->string('nombre');
            $table->string('N_documento');
            $table->string('fecha_nacimiento');
        });
    }
};