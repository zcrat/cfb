<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosInstaladas extends Model
{
    protected $table = 'fotos_instaladas';
    protected $fillable = [
        'id',
        'presupuestoCFE_id',
        'archivo',
    ];
}
