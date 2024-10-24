<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenServicio2 extends Model
{
    protected $table = 'orden_servicio2';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
