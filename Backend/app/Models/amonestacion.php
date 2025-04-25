<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amonestacion extends Model
{
    use HasFactory;

    protected $table = 'amonestaciones'; 

    protected $fillable = [
        'nombre_jugador',
        'numero_camiseta',
        'equipo',
        'encuentro_disputado',
        'tarjeta_amarilla',
        'tarjeta_roja',
        'tarjeta_azul',
    ]; 
}
