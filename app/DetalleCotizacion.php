<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCotizacion extends Model
{
    protected $table = 'cotizacion3_detalle_cotizacion';
    protected $fillable = [
        'id', 
        'detalle_cotizacion_id',
        'cotizacion3_id', 
        'idarticulo',
        'cantidad',
        'precio'
    ];
    public $timestamps = false;
}
