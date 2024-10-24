<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioOrden2023 extends Model
{
    protected $table = 'servicio_orden2023';
    protected $fillable =[
        'id',
        'presupuesto_id',
        'preocorr_id',
        'ubicacion',
        'area'
    ];
}
