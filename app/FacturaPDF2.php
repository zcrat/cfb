<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaPDF2 extends Model
{
    protected $table = 'factura_pdf2';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
