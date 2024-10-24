<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenesForaneas extends Model
{
    protected $table = 'ordenes_foraneas';
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
