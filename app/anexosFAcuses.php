<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFAcuses extends Model
{
    protected $table = 'anexosfacuses';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
