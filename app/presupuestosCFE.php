<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class presupuestosCFE extends Model
{
    protected $table = 'presupuestosCFE';
    protected $fillable = [
        'd',
        'pCFEVehiculos_id',
        'pCFEGenerales_id',
        'descripcionMO',
        'fechaDeVigencia',
        'tiempo',
        'importe',
        'observaciones',
        'user_id',
        'factura_id',
        'listo',
        'status'
    ];
}
