<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasSave extends Model
{
    protected $table = 'facturas_save';
    protected $fillable = [
        'id', 
        'empresa_id',
        'user_id',
        'fpago',
        'moneda',
        'mpago',
        'tipo_comprobante',
        'tipo_impuesto_local'
     ];
}
