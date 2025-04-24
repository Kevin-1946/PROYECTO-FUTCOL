<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amonestacion extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos (opcional si sigue la convención de Laravel)
    protected $table = 'amonestaciones'; 

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'tarjeta_roja',
        'tarjeta_amarilla',
        'tarjeta_azul',
    
    ]; 
}
