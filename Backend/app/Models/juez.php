<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class juez extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos (opcional si sigue la convención de Laravel)
    protected $table = 'juez'; 

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'numero_de_contacto',
    
    ]; 
}
