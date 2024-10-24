<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteAnomalias extends Model
{
    protected $table = 'reporte_anomalias';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'archivo',
    ];
}
