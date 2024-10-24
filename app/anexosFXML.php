<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFXML extends Model
{
    protected $table = 'anexosfxml';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
