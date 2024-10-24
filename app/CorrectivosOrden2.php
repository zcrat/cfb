<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectivosOrden2 extends Model
{
    protected $table = 'correctivos_orden2';
    protected $fillable =[
        'id',
        'presupuesto_id',
        'correctivo_id'
    ];
}
