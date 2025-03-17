<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use app\Models\Recepcionvehiculardemo;
class FotosRecepcionVehicvular extends Model
{
    use SoftDeletes;
    protected $table='fotos_recepcion_vehicular';

    protected $fillable =[
        'Recepcion_Vehicular_id','image',
    ];
    
    function recepcionvehicular(){
        return $this->belongsTo(Recepcionvehiculardemo::class,'id','Recepcion_Vehicular_id');
    }
}
