<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFFotosInstaladas extends Model
{
    protected $table = 'anexosffotosinstaladas';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
