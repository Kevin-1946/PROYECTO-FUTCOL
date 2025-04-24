<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resultados extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos (opcional si sigue la convención de Laravel)
    protected $table = 'resultados'; 

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'puntos',
        'partidos_jugados',
        'goles_a_favor',
        'goles_en_contra',
        'diferencia_de_goles',
        'equipo'
    
    ]; 
}
