<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFSO extends Model
{
    protected $table = 'anexosfso';
    protected $fillable =[
        'id',
        'presupuesto_id',
        'preocorr_id',
        'ubicacion',
        'area'
    ];
}
