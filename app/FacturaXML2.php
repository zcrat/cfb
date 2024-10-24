<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaXML2 extends Model
{
    protected $table = 'factura_xml2';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
