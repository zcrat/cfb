<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosNuevas2 extends Model
{
    protected $table = 'fotos_nuevas2';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
