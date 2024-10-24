<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFFotosViejas extends Model
{
    protected $table = 'anexosffotosviejas';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
