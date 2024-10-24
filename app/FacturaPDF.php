<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaPDF extends Model
{
    protected $table = 'factura_pdf';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'archivo',
    ];
}
