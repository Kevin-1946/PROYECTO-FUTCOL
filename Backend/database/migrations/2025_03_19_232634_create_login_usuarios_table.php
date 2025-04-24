<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('LoginUsuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->enum('tipo_documento', ['C.C', 'T.I']);
            $table->string('numero_documento')->unique();
            $table->string('email')->unique();
            $table->integer('edad')->nullable();
            $table->string('genero', 50);
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('LoginUsuario');
    }
};

