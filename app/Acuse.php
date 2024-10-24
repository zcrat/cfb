<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acuse extends Model
{
    protected $table = 'acuse';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'archivo',
    ];
}
