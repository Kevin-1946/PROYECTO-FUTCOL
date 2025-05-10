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
        Schema::table('equipo', function (Blueprint $table) {
            $table->json('jugadores')->nullable()->after('nombre_de_equipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipo', function (Blueprint $table) {
            $table->dropColumn('jugadores');
        });
    }
};
