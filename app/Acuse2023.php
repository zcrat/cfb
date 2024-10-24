<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acuse2023 extends Model
{
    protected $table = 'acuse2023';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
