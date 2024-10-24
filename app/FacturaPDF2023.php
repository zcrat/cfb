<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaPDF2023 extends Model
{
    protected $table = 'factura_pdf2023';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
