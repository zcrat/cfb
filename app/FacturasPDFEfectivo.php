<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasPDFEfectivo extends Model
{
    protected $table = 'facturas_pdf_efectivo';
    protected $fillable = [
        'id', 
        'caja_id',
        'archivo',
     ];
}
