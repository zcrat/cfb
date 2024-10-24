<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReparacionesTrasladistas extends Model
{
    protected $table = 'reparaciones_trasladistas';
    protected $fillable = [
        'id',
        'economico_placas',
        'empresa',
        'id_trasladista',
        'fecha',
        'fecha_entrega',
        'recibio',
        'status'

    ];
}
