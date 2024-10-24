<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaXML extends Model
{
    protected $table = 'factura_xml';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'archivo',
    ];
}
