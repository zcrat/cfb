<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioOrden extends Model
{
    protected $table = 'servicio_orden';
    protected $fillable =[
        'id',
        'presupuestoCFE_id',
        'preocorr_id',
        'ubicacion',
        'area'
    ];
}
