<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class suscripcion extends Authenticatable
{
    use HasFactory;

    protected $table = 'suscripcion';

    protected $fillable = [
        'tipo_documento',
        'numero_documento',
        'nombres',
        'apellidos',
        'edad',
        'email',
        'genero',
        'contrasena',
        'tipo_torneo',
        'forma_pago'
    ];

    protected $hidden = [
        'contraseña',
    ];
}
