<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasXMLBancos extends Model
{
    protected $table = 'facturas_xml_bancos';
    protected $fillable = [
        'id', 
        'caja_bancos_id',
        'archivo',
     ];
}
