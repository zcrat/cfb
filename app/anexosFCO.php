<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFCO extends Model
{
    protected $table = 'anexosfco';
    protected $fillable =[
        'id',
        'presupuesto_id',
        'correctivo_id'
    ];
}
