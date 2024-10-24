<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenServicio2023 extends Model
{
    protected $table = 'orden_servicio2023';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
