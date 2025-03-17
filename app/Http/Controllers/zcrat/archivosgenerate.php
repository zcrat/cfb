<?php

namespace App\Http\Controllers\Zcrat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\pCFECategorias;
use App\pCFETipos;
use App\CodigoSat;
use App\Contratos;
use App\presupuestosCFE;

class archivosgenerate extends Controller
{
    public function cfeeco(){
        $buscar = $request->buscar;
        $contrato = $request->contrato;
        $criterio = $request->criterio;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;

        if(\Auth::user()->id == 1){
            $categorias = pCFECategorias::where('CFE_id','=','6')->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();
        } else {
            $categorias = pCFECategorias::where('CFE_id','=','6')->where('sucursal_id','=',\Auth::user()->sucursal_id)->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();
        }
        $productos = CodigoSat::get();
        $contratos = Contratos::get();
       
        $cotizacionesQuery = presupuestosCFE::join('pCFEVehiculos', 'presupuestosCFE.pCFEVehiculos_id', '=', 'pCFEVehiculos.id')
        ->join('pCFEGenerales', 'presupuestosCFE.pCFEGenerales_id', '=', 'pCFEGenerales.id')
        ->join('users', 'presupuestosCFE.user_id', '=', 'users.id')
        ->join('sucursales', 'users.sucursal_id', '=', 'sucursales.id')
        ->join('contratos', 'sucursales.contratos_id', '=', 'contratos.id')
        ->select(
            'presupuestosCFE.id', 
            'pCFEGenerales.NSolicitud', 
            'pCFEGenerales.FechaAlta', 
            'pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso', 
            'pCFEVehiculos.identificador', 
            'pCFEVehiculos.kilometraje', 
            'pCFEVehiculos.marca',
            'pCFEVehiculos.modelo', 
            'pCFEVehiculos.ano', 
            'pCFEVehiculos.placas', 
            'pCFEVehiculos.vin', 
            'pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail', 
            'pCFEGenerales.Telefono', 
            'pCFEGenerales.Conductor', 
            'presupuestosCFE.created_at', 
            'presupuestosCFE.observaciones', 
            'presupuestosCFE.status', 
            'pCFEVehiculos.id as pCFEVehiculos_id', 
            'pCFEGenerales.id as pCFEGenerales_id',
            'presupuestosCFE.descripcionMO', 
            'presupuestosCFE.importe', 
            'presupuestosCFE.importep', 
            'presupuestosCFE.ubicacion', 
            'presupuestosCFE.tdeentrega', 
            'presupuestosCFE.area', 
            'contratos.numero as contrato', 
            'presupuestosCFE.factura_id', 
            'presupuestosCFE.tramite'
        )
        ->where('presupuestosCFE.CFE_id', '=', '6')
        ->where($criterio, 'like', '%' . $buscar . '%')
        ->where('contratos.id', 'like', '%' . $contrato . '%')
        ->where('presupuestosCFE.id_anio_correspondiente', '=', '2');
    
    // Verificar si las fechas no son nulas antes de aplicar whereBetween
    if (!empty($request->fecha_inicio) && !empty($request->fecha_final)) {
        $cotizacionesQuery->whereBetween('presupuestosCFE.created_at', [$request->fecha_inicio, $request->fecha_final]);
    }
    
    // Finalmente, obtener los resultados
    $cotizaciones = $cotizacionesQuery->orderBy('presupuestosCFE.id', 'desc')->get();
    
    return ['excel' => 'ruta-archivo'];

    }
}
