<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteAnomalias2023 extends Model
{
    protected $table = 'reporte_anomalias2023';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
