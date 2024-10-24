<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFFotosNuevas extends Model
{
    protected $table = 'anexosffotosnuevas';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
