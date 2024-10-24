<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosInstaladas2 extends Model
{
    protected $table = 'fotos_instaladas2';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
