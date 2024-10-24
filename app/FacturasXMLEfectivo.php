<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasXMLEfectivo extends Model
{
    protected $table = 'facturas_xml_efectivo';
    protected $fillable = [
        'id', 
        'caja_id',
        'archivo',
     ];
}
