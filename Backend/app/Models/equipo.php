<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipo extends Model
{
    use HasFactory;

    protected $table = 'equipo';

    protected $fillable = [
        'nombre_de_equipo',
        'jugadores',
    ];

    protected $casts = [
        'jugadores' => 'array',
    ];
}