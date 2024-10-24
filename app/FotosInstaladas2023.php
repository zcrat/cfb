<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosInstaladas2023 extends Model
{
    protected $table = 'fotos_instaladas2023';
    protected $fillable = [
        'id',
        'presupuesto_id',
        'archivo',
    ];
}
