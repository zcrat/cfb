<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioOrden2 extends Model
{
    protected $table = 'servicio_orden2';
    protected $fillable =[
        'id',
        'presupuesto_id',
        'preocorr_id',
        'ubicacion',
        'area'
    ];
}
