<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePagos extends Model
{
    protected $table = 'detalle_pagos';
    protected $fillable = [
        'factura_id',
        'pago_id',
        'uuid',
        'folio',
        'serie',
        'total',
        'mpago',
        'moneda',
        'pago',
        'impuestosa',
        'impuestosi',
        'impuestopago',
        'nparcialidades'
    ];
}
