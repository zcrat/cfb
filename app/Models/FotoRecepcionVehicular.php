<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FotoRecepcionVehicular extends Model
{
    use  SoftDeletes;

    protected $table = 'FotosRecepcionesVehiculares';

    protected $fillable = ['RecepcionVehicular_id', 'Foto'];

    public function recepcionVehicular()
    {
        return $this->belongsTo(RecepcionesVehiculares::class, 'RecepcionVehicular_id','id');
    }
}
