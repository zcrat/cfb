<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntradasSalidas extends Model
{
    protected $table = 'entradas_salidas';
    protected $fillable = [
        'id',
        'empresa',
        'n_orden',
        'hora_entrada',
        'orden_servicio',
        'economico',
        'placas',
        'kms',
        'serie',
        'fecha_entrada',
        'fecha_salida',
        'observaciones',
        'asignado'
    ];
}
