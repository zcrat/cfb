<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosNuevas2023 extends Model
{
    protected $table = 'fotos_nuevas2023';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
