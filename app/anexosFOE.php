<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFOE extends Model
{
    protected $table = 'anexosfoe';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
