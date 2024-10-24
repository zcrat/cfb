<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ESForaneas extends Model
{
    protected $table = 'es_foraneas';
    protected $fillable = [
        'id',
        'empresa',
        'n_orden',
        'hora_entrada',
        'plaza',
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
