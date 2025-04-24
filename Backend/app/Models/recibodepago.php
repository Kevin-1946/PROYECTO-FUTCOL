<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recibo_de_pago extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos (opcional si sigue la convención de Laravel)
    protected $table = 'recibo_de_pago'; 

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'confirmacion_de_pago',
        'fecha_emision',
        'monto',
        
    ]; 
}
