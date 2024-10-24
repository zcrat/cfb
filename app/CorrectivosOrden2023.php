<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectivosOrden2023 extends Model
{
    protected $table = 'correctivos_orden2023';
    protected $fillable =[
        'id',
        'presupuesto_id',
        'correctivo_id'
    ];
}
