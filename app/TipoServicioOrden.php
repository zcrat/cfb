<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoServicioOrden extends Model
{
    protected $table = 'tipo_servicio_orden';
    protected $fillable = [
        'd',
        'presupuestoCFE_id',
        'tipo_servicio'
    ];
}
