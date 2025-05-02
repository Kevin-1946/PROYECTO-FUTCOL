<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramacionJuez extends Model
{
    use HasFactory;

    // Nombre de la tabla explícitamente
    protected $table = 'programacion_juez'; 

    // Campos que se pueden llenar desde formularios o requests
    protected $fillable = [
        'nombre',
        'numero_de_contacto',
        'sede',
        'encuentros_id'
    ];

    // Relación con la tabla encuentros
    public function encuentro()
    {
        return $this->belongsTo(Encuentro::class, 'encuentros_id');
    }
}
