<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipo extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos (opcional si sigue la convención de Laravel)
    protected $table = 'equipo'; 

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre_de_equipo',
    ]; 
}
