<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasPDFBancos extends Model
{
    protected $table = 'facturas_pdf_bancos';
    protected $fillable = [
        'id', 
        'caja_bancos_id',
        'archivo',
     ];
}
