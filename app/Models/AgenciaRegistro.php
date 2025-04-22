<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenciaRegistro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'celular',
        'documento',
        'numero',
        'correo',
        'aceptado',
        'archivo'
    ];
}
