<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenEntrada extends Model
{
    protected $table = 'orden_entrada';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'archivo',
    ];
}
