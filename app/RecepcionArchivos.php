<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecepcionArchivos extends Model
{
    protected $table = 'recepcion_archivos';
    protected $fillable = [
        'id',
        'recepcion_id',
        'nombre',
        'tipo'
    ];
}
