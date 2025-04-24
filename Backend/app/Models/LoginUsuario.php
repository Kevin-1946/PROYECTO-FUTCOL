<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class LoginUsuario extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'loginusuario';

    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'email',
        'edad',
        'genero',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = true;

    // JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
