<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasEmisor extends Model
{
    protected $table = 'facturas_emisor';
    protected $fillable = [
        'id', 
        'n_certificado',
        'archivo_cer',
        'archivo_key',
        'clave_key',
        'rfc_emisor',
        'nombre_emisor',
        'regimen_emisor',
        'codigo_emisor',
        'serie_factura',
        'folio_factura'
     ];
     
}
