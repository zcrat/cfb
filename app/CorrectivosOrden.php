<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectivosOrden extends Model
{
    protected $table = 'correctivos_orden';
    protected $fillable =[
        'id',
        'presupuestoCFE_id',
        'correctivo_id'
    ];
}
