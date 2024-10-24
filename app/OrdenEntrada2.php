<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenEntrada2 extends Model
{
    protected $table = 'orden_entrada2';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
