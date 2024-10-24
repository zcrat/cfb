<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehiculosTareas extends Model
{
    protected $table = 'vehiculos_tareas';
    protected $fillable = [
        'id',
        'economico',
        'odometro_entrada',
        'odometro_salida',
        'placas',
        'serie',
        'cliente'
    ];
}
