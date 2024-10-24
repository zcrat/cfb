<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenTecnicos extends Model
{
    protected $table = 'orden_tecnicos';
    protected $fillable = [
        'id',
        'reparaciones_id',
        'archivo',
    ];
}
