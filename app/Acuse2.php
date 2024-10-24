<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acuse2 extends Model
{
    protected $table = 'acuse2';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
