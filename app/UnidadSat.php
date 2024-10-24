<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadSat extends Model
{
    protected $table = 'unidad_sat';
    protected $fillable = [
        'code',
        'nombre',
        'descripcion'
    ];
}
