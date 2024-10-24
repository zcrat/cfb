<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasCajaBancos extends Model
{
    protected $table = 'facturas_caja_bancos';
    protected $fillable = [
        'id',
        'caja_bancos_id',
        'folio',
        'numero',
        'monto',
    ];
}
