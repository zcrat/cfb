<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosViejas2 extends Model
{
    protected $table = 'fotos_viejas2';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
