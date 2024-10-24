<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoServicioOrden2023 extends Model
{
    protected $table = 'tipo_servicio_orden2023';
    protected $fillable = [
        'd',
        'presupuesto_id',
        'tipo_servicio'
    ];
}
