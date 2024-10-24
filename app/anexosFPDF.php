<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFPDF extends Model
{
    protected $table = 'anexosfpdf';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
