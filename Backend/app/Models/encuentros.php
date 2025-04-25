<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuentros extends Model
{
    use HasFactory;

    protected $table = 'encuentros';

    protected $fillable = [
        'sede',
        'fecha',
        'hora',
        'local',
        'visitante',
    ];
}
