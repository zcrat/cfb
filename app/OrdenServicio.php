<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{
    protected $table = 'orden_servicio';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'archivo',
    ];
}
