<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CondicionesPintura;
use App\Models\EquipoInventario;
use App\Models\ExterioresEquipo;
use App\Models\InterioresEquipo;
use App\Models\TecnicoTaller;
class RecepcionesVehiculares extends Model
{
    use SoftDeletes;

    protected $table = 'RecepcionesVehiculares';

    protected $fillable = [
        'DetallesGenerales_id', 'Notas', 'Tecnico_id', 
        'Firma', 'Carro','Update_fotos'
    ];

    public function detallesGenerales()
    {
        return $this->belongsTo(DetallesGenerales::class, 'DetallesGenerales_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoRecepcionVehicular::class, 'RecepcionVehicular_id');
    }
    public function tecnico()
    {
        return $this->belongsTo(TecnicoTaller::class, 'Tecnico_id');
    }
    public function pintura()
    {
        return $this->hasMany(CondicionesPintura::class, 'RecepcionVehicular_id');
    }
    public function inventario()
    {
        return $this->hasMany(EquipoInventario::class, 'RecepcionVehicular_id');
    }
    public function exteriores()
    {
        return $this->hasMany(ExterioresEquipo::class, 'RecepcionVehicular_id');
    }
    public function interiores()
    {
        return $this->hasMany(InterioresEquipo::class, 'RecepcionVehicular_id');
    }
   
}
