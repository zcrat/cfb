<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosViejas2023 extends Model
{
    protected $table = 'fotos_viejas2023';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
