<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Vehiculo;
use App\Models\Empresa;
use App\Models\Customer;
use App\Models\Contratos;
use App\Models\Modulo;
use App\Models\Sucursales;
use App\Models\Presupuesto;
use App\User;
use App\Models\AdministradorTransporte;
use App\Models\JefeDeProceso;
use App\Models\Trabajador;
use App\Models\RecepcionesVehiculares;


class DetallesGenerales extends Model
{
    use SoftDeletes;

    protected $table = 'DetallesGenerales';
    protected $with=['Vehiculo','Empresa'];
    protected $fillable = [
        'OrdenServicio', 'OrdenSeguimiento', 'Folio', 'Fecha_Esperada',
        'Kilometraje_entrada', 'Gas_entrada', 'Fecha_entrada',
        'Kilometraje_salida', 'Gas_salida', 'Fecha_salida', 'Vehiculo_id',
        'User_id','User_update_id', 'Empresa_id', 'Customer_id', 'AdministradorTrasporte_id',
        'JefedeProceso_id', 'Trabajador_id', 'Telefono', 'contrato_id',
        'modulo_id', 'anio', 'zona_id','Indicaciones_cliente'
    ];

    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class, 'DetallesGenerales_id');
    }
    
    public function recepcionesVehiculares()
    {
        return $this->hasMany(RecepcionesVehiculares::class, 'DetallesGenerales_id');
    }
    public function Vehiculo()
    {
        return $this->belongsto(Vehiculo::class, 'Vehiculo_id');
    }
    public function User()
    {
        return $this->belongsto(User::class, 'User_id');
    }
    public function User_update()
    {
        return $this->belongsto(User::class, 'User_update_id');
    }
    public function Empresa()
    {
        return $this->belongsto(Empresa::class, 'Empresa_id');
    }
    public function Customer()
    {
        return $this->belongsto(Customer::class, 'Customer_id');
    }
    public function AdministradorTrasporte()
    {
        return $this->belongsto(AdministradorTransporte::class, 'AdministradorTrasporte_id');
    }
    public function JefedeProceso()
    {
        return $this->belongsto(JefeDeProceso::class, 'JefedeProceso_id');
    }
    public function Trabajador()
    {
        return $this->belongsto(Trabajador::class, 'Trabajador_id');
    }
    public function contrato()
    {
        return $this->belongsto(Contratos::class, 'contrato_id');
    }
    public function modulo()
    {
        return $this->belongsto(Modulo::class, 'modulo_id');
    }
    public function zona()
    {
        return $this->belongsto(Sucursales::class, 'zona_id');
    }
}
