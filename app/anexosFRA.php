<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFRA extends Model
{
    protected $table = 'anexosfra';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}