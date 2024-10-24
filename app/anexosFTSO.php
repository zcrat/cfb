<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFTSO extends Model
{
    protected $table = 'anexosftso';
    protected $fillable = [
        'd',
        'presupuesto_id',
        'tipo_servicio'
    ];
}
