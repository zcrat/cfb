<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenesPagadas extends Model
{
    protected $table = 'ordenes_pagos';
    protected $fillable = [
        'id',
        'fecha',
        'orden',
        'empresa',
        'placa',
        'serie',
        'os',
        'folio_sistema',
        'presupuesto',
        'factura',
        'monto',
        'iva',
        'total',
        'status'
    ];
}
