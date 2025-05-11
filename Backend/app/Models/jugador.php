<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jugador extends Model
{
    use HasFactory;

    protected $table = 'jugador';

    protected $fillable = [
        'nombre_jugador',
        'numero_camiseta',
        'edad',
        'nombre_equipo',
        'goles_a_favor'
    ];
}