<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasCaja extends Model
{
    protected $table = 'facturas_caja';
    protected $fillable = [
        'id',
        'caja_id',
        'folio',
        'numero',
        'monto',
    ];
}
