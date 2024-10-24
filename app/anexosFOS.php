<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFOS extends Model
{
    protected $table = 'anexosfos';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
