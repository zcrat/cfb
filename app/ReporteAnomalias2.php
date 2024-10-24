<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteAnomalias2 extends Model
{
    protected $table = 'reporte_anomalias2';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
