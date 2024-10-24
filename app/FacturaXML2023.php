<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaXML2023 extends Model
{
    protected $table = 'factura_xml2023';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
