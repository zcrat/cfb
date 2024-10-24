<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenEntrada2023 extends Model
{
    protected $table = 'orden_entrada2023';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
