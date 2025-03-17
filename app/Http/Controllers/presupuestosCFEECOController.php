<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\presupuestosCFE;
use App\pCFEVehiculos;
use App\pCFEGenerales;
use App\pCFECategorias;
use App\pCFETipos;
use App\Productos;
use App\pCFECarrito;
use App\CodigoSat;
use App\FotosViejas;
use App\FotosNuevas;
use App\FotosInstaladas;
use App\Acuse;
use App\OrdenServicio;
use App\FacturaXML;
use App\FacturaPDF;
use App\Factura;
use App\Contratos;
use App\ReporteAnomalias;
use Response;
use App\CorrectivosOrden;
use App\ServicioOrden;
use App\ServicioEntrada;
use App\TipoServicioOrden;
use App\OrdenEntrada;
use App\Sucursales;
use App\FacturasSaveDetalle;

use DB;
use Illuminate\Support\Carbon;


class presupuestosCFEECOController extends Controller
{
    public function index(Request $request)
    {

        $id = \Auth::user()->id;

        $ids = \Auth::user()->sucursal_id;

        $m = Sucursales::join('contratos','sucursales.contratos_id','=','contratos.id')
        ->select('contratos.id','contratos.nombre','contratos.monto','contratos.numero')
        ->where('sucursales.id','=',$ids)->get();

        $idcontrato = $m[0]['id'];

        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if(\Auth::user()->id == 1){
            $categorias = pCFECategorias::where('CFE_id','=','6')->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();
        } else {
            $categorias = pCFECategorias::where('CFE_id','=','6')->where('sucursal_id','=',\Auth::user()->sucursal_id)->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();

        }
      
        
        $productos = CodigoSat::get();
        $contratos = Contratos::get();
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;
        if ($fecha_inicio=='' || $fecha_final=='' ){
        if ($buscar==''){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$idcontrato)
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
        }
        else{
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area')
            ->where('presupuestosCFE.CFE_id','=','6')
            // ->where('presupuestosCFE.user_id','=',$id)
            ->where($criterio, 'like', '%'. $buscar . '%')->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
        }
        } else {
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area')
            ->where('presupuestosCFE.CFE_id','=','6')
            // ->where('presupuestosCFE.user_id','=',$id)
            ->whereBetween('presupuestosCFE.created_at', [$request->fecha_inicio, $request->fecha_final])
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(30);

        }
         
        return [
            'pagination' => [
                'total'        => $cotizaciones->total(),
                'current_page' => $cotizaciones->currentPage(),
                'per_page'     => $cotizaciones->perPage(),
                'last_page'    => $cotizaciones->lastPage(),
                'from'         => $cotizaciones->firstItem(),
                'to'           => $cotizaciones->lastItem(),
            ],
            'cotizaciones' => $cotizaciones,
            'categorias' => $categorias,
            'tipos' => $tipos,
            'productos' => $productos,
            'contratos' => $contratos,
        ];
    }  

    public function indexAll(Request $request)
    {

        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $contra = $request->contra;
        $contrato = $request->contrato;
        $criterio = $request->criterio;
        if(\Auth::user()->id == 1){
            $categorias = pCFECategorias::where('CFE_id','=','6')->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();
        } else {
            $categorias = pCFECategorias::where('CFE_id','=','6')->where('sucursal_id','=',\Auth::user()->sucursal_id)->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();

        }
        $productos = CodigoSat::get();
        $contratos = Contratos::get();
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;
        if ($fecha_inicio=='' || $fecha_final=='' ){
        if ($contra == '1'){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$buscar)->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
         } else {
 
        if ($buscar==''){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
        }
        else{
            if($contrato == 0){
                $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
                ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
                ->join('users','presupuestosCFE.user_id','=','users.id')
                ->join('sucursales','users.sucursal_id','=','sucursales.id')
                ->join('contratos','sucursales.contratos_id','=','contratos.id')
                ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
                'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
                'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
                'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
                ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
                ->where('presupuestosCFE.CFE_id','=','6')
                ->where($criterio, 'like', '%'. $buscar . '%')->where('presupuestosCFE.id_anio_correspondiente','=','2')
                ->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
            } else {
                $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
                ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
                ->join('users','presupuestosCFE.user_id','=','users.id')
                ->join('sucursales','users.sucursal_id','=','sucursales.id')
                ->join('contratos','sucursales.contratos_id','=','contratos.id')
                ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
                'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
                'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
                'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
                ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
                ->where('presupuestosCFE.CFE_id','=','6')
                ->where('contratos.id', '=', $contrato)
                ->where($criterio, 'like', '%'. $buscar . '%')->where('presupuestosCFE.id_anio_correspondiente','=','2')
                ->orderBy('presupuestosCFE.id', 'desc')->paginate(20);
            }
           
         }
         }
        } else {
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->whereBetween('presupuestosCFE.created_at', [$request->fecha_inicio, $request->fecha_final])
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(30);

        }
        return [
            'pagination' => [
                'total'        => $cotizaciones->total(),
                'current_page' => $cotizaciones->currentPage(),
                'per_page'     => $cotizaciones->perPage(),
                'last_page'    => $cotizaciones->lastPage(),
                'from'         => $cotizaciones->firstItem(),
                'to'           => $cotizaciones->lastItem(),
            ],
            'cotizaciones' => $cotizaciones,
            'categorias' => $categorias,
            'tipos' => $tipos,
            'productos' => $productos,
            'contratos' => $contratos,
        ];
    }

    public function indexCFE(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        $id = \Auth::user()->sucursal_id;

        $m = Sucursales::join('contratos','sucursales.contratos_id','=','contratos.id')
        ->select('contratos.id','contratos.nombre','contratos.monto','contratos.numero')
        ->where('sucursales.id','=',$id)->get();

        $idcontrato = $m[0]['id'];

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if(\Auth::user()->id == 1){
            $categorias = pCFECategorias::where('CFE_id','=','6')->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();
        } else {
            $categorias = pCFECategorias::where('CFE_id','=','6')->where('sucursal_id','=',\Auth::user()->sucursal_id)->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();

        }
        
        $productos = Productos::get();
        $contratos = Contratos::get();
         
        if ($buscar==''){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$idcontrato)
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(40);
        }
        else{
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where($criterio, 'like', '%'. $buscar . '%')->where('contratos.id','=',$idcontrato)->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(40);
        }
         
        return [
            'pagination' => [
                'total'        => $cotizaciones->total(),
                'current_page' => $cotizaciones->currentPage(),
                'per_page'     => $cotizaciones->perPage(),
                'last_page'    => $cotizaciones->lastPage(),
                'from'         => $cotizaciones->firstItem(),
                'to'           => $cotizaciones->lastItem(),
            ],
            'cotizaciones' => $cotizaciones,
            'categorias' => $categorias,
            'tipos' => $tipos,
            'productos' => $productos,
            'contratos' => $contratos,
        ];
    }

    public function indexCFEBuscar(Request $request)
    {
      

        if (!$request->ajax()) return redirect('/');

        $id = \Auth::user()->sucursal_id;

        $m = Sucursales::join('contratos','sucursales.contratos_id','=','contratos.id')
        ->select('contratos.id','contratos.nombre','contratos.monto','contratos.numero')
        ->where('sucursales.id','=',$id)->get();

        $idcontrato = $m[0]['id'];

        $buscar = $request->finicio;
        $buscar2 = $request->ffinal;
        $servicio = $request->servicio;
        $ubicacion = $request->ubi;
        $criterio = $request->criterio;
        $tipo_correctivo = $request->tipo_correctivo;
        $tipo_servicio = $request->tipo_servicio;
        if(\Auth::user()->id == 1){
            $categorias = pCFECategorias::where('CFE_id','=','6')->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();
        } else {
            $categorias = pCFECategorias::where('CFE_id','=','6')->where('sucursal_id','=',\Auth::user()->sucursal_id)->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();

        }
        $productos = Productos::get();
        $contratos = Contratos::get();

        if ($buscar != null && $buscar2 != null && $servicio == 1 && $ubicacion != "" && $criterio != "" && $tipo_servicio != 0 ){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->join('servicio_orden','presupuestosCFE.id','=','servicio_orden.presupuestoCFE_id')
            ->join('tipo_servicio_orden','presupuestosCFE.id','=','tipo_servicio_orden.presupuestoCFE_id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->where('tipo_servicio_orden.tipo_servicio','=',$tipo_servicio)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(40);
        }

        if ($buscar != null && $buscar2 != null && $servicio == 1 && $ubicacion != "" && $criterio != "" && $tipo_servicio == 0 ){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->join('servicio_orden','presupuestosCFE.id','=','servicio_orden.presupuestoCFE_id')
            ->join('tipo_servicio_orden','presupuestosCFE.id','=','tipo_servicio_orden.presupuestoCFE_id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(40);
        }
         

        if ($buscar != null && $buscar2 != null && $servicio == 2 | $ubicacion != "" && $criterio != "" && $tipo_correctivo != 0 ){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->join('servicio_orden','presupuestosCFE.id','=','servicio_orden.presupuestoCFE_id')
            ->join('correctivos_orden','presupuestosCFE.id','=','correctivos_orden.presupuestoCFE_id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->where('correctivos_orden.correctivo_id','=',$tipo_correctivo)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(40);
        }

        if ($buscar != null && $buscar2 != null && $servicio == 2 | $ubicacion != "" && $criterio != "" && $tipo_correctivo == 0 ){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->join('servicio_orden','presupuestosCFE.id','=','servicio_orden.presupuestoCFE_id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(40);
        }

        if ($buscar != null && $buscar2 != null && $servicio == 0 && $ubicacion == "" && $criterio == "" && $request->buscar != "" ){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEVehiculos.'.$request->criterios,'=',$request->buscar)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(40);
        }

        if ($buscar != null && $buscar2 != null && $servicio == 2 | $ubicacion != "" && $criterio == "" && $request->buscar == "" ){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->join('servicio_orden','presupuestosCFE.id','=','servicio_orden.presupuestoCFE_id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(40);
        }


        
        
         
        return [
            'pagination' => [
                'total'        => $cotizaciones->total(),
                'current_page' => $cotizaciones->currentPage(),
                'per_page'     => $cotizaciones->perPage(),
                'last_page'    => $cotizaciones->lastPage(),
                'from'         => $cotizaciones->firstItem(),
                'to'           => $cotizaciones->lastItem(),
            ],
            'cotizaciones' => $cotizaciones,
            'categorias' => $categorias,
            'tipos' => $tipos,
            'productos' => $productos,
            'contratos' => $contratos,
        ];
    }

    public function exel(Request $request)
    {
       
       
 
        $buscar = $request->buscar;
        $contra = $request->contra;
        $contrato = $request->contrato;
        $criterio = $request->criterio;
        if(\Auth::user()->id == 1){
            $categorias = pCFECategorias::where('CFE_id','=','6')->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();
        } else {
            $categorias = pCFECategorias::where('CFE_id','=','6')->where('sucursal_id','=',\Auth::user()->sucursal_id)->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','6')->orderBy('tipo', 'asc')->get();

        }
        $productos = CodigoSat::get();
        $contratos = Contratos::get();
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;
        if ($fecha_inicio=='' || $fecha_final=='' ){
        if ($contra == '1'){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('contratos.id','=',$buscar)->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
         } else {
 
        if ($buscar==''){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
        }
        else{
            if($contrato == 0){
                $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
                ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
                ->join('users','presupuestosCFE.user_id','=','users.id')
                ->join('sucursales','users.sucursal_id','=','sucursales.id')
                ->join('contratos','sucursales.contratos_id','=','contratos.id')
                ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
                'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
                'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
                'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
                ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
                ->where('presupuestosCFE.CFE_id','=','6')
                ->where($criterio, 'like', '%'. $buscar . '%')->where('presupuestosCFE.id_anio_correspondiente','=','2')
                ->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
            } else {
                $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
                ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
                ->join('users','presupuestosCFE.user_id','=','users.id')
                ->join('sucursales','users.sucursal_id','=','sucursales.id')
                ->join('contratos','sucursales.contratos_id','=','contratos.id')
                ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
                'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
                'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
                'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
                ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
                ->where('presupuestosCFE.CFE_id','=','6')
                ->where('contratos.id', '=', $contrato)
                ->where($criterio, 'like', '%'. $buscar . '%')->where('presupuestosCFE.id_anio_correspondiente','=','2')
                ->orderBy('presupuestosCFE.id', 'desc')->paginate(20);
            }
           
         }
         }
        } else {
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
            ->where('presupuestosCFE.CFE_id','=','6')
            ->whereBetween('presupuestosCFE.created_at', [$request->fecha_inicio, $request->fecha_final])
            ->where('presupuestosCFE.id_anio_correspondiente','=','2')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(30);

        }
    
         
    return \View::make('pdf.exelExport')->with('detalles',$cotizaciones);
    }

  
 
    public function store(Request $request)
    {
       
  
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            $fechita = Carbon::parse($request->fecha)->format('Y-m-d H:m');


            $vehiculo = new pCFEVehiculos();
            $vehiculo->identificador = $request->identificador;
            $vehiculo->modelo = $request->modelo;
            $vehiculo->vin = $request->vin;
            $vehiculo->placas = $request->placas;
            $vehiculo->ano = $request->ano;
            $vehiculo->kilometraje = $request->kilometraje;
            $vehiculo->marca = $request->marca;
            $vehiculo->fecha = $fechita;
            $vehiculo->save();

            $fechaAl = Carbon::parse($request->fechaalta)->format('Y-m-d H:m');
            $generales = new pCFEGenerales();
            $generales->NSolicitud = $request->nsolicitud;
            $generales->FechaAlta = $fechaAl;
            $generales->OrdenServicio = $request->ordenservicio;
            $generales->KmDeIngreso = $request->kmdeingreso;
            $generales->ClienteYRazonSocial = $request->clienteYRazonSocial;
            $generales->Mail = $request->mail;
            $generales->Telefono = $request->telefono;
            $generales->Conductor = $request->conductor;
            $generales->Fecha = $fechita;
            $generales->save();

            
 
            
            $cotizacion = new presupuestosCFE();
            $cotizacion->pCFEVehiculos_id = $vehiculo->id;
            $cotizacion->pCFEGenerales_id = $generales->id;
            $cotizacion->descripcionMO = $request->descripcionMO;
            $cotizacion->fechaDeVigencia = $request->fechaDeVigencia;
            $cotizacion->tiempo = $request->tiempo;
            $cotizacion->importe =$request->importe;
            $cotizacion->observaciones =$request->observaciones;
            $cotizacion->user_id = \Auth::user()->id;
            $cotizacion->ubicacion =$request->ubicacion;
            $cotizacion->area =$request->area;
            $cotizacion->CFE_id='6';
            $cotizacion->save();   
            
            // $coti = new ServicioOrden();
            // $coti->presupuestoCFE_id = $cotizacion->id;
            // $coti->preocorr_id = $request->preocorr_id;    
            // $coti->ubicacion = $request->ubi;
            // $coti->area = $request->area;
            // $coti->save();


            // if($request->preocorr_id == "2"){

            //     $detalles = $request->data;//Array de detalles
            //     foreach($detalles as $ep=>$det)
            //     {
            //         $detalle = new CorrectivosOrden();
            //         $detalle->presupuestoCFE_id = $cotizacion->id;
            //         $detalle->correctivo_id = $det['id'];      
            //         $detalle->save();
            //     }     

            // } 
            // if($request->preocorr_id == "1"){
            //     $ser = new TipoServicioOrden();
            //     $ser->presupuestoCFE_id = $cotizacion->id;
            //     $ser->tipo_servicio = $request->tipo_servicio;
            //     $ser->kilometros = $request->kilome;
            //     $ser->save();

            // }

          
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    

    public function selectTipos(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = pCFECategorias::select('id','num','titulo')
        ->where('CFE_id','=','6')
        ->orderBy('id', 'asc')->get();
        return ['categorias' => $categorias];
    }

    public function selectCategorias(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = pCFETipos::select('id','tipo')
        ->where('CFE_id','=','6')
        ->orderBy('id', 'asc')->get();
        return ['tipos' => $categorias];
    }

   
    public function tipo(Request $request)
    {
        $tipo = new pCFETipos();
        $tipo->tipo = $request->nombre; 
        $tipo->CFE_id = '6';   
        $tipo->save();

        
        $tipos = pCFETipos::where('CFE_id','=','6')->get();
        return [
            'tipos' => $tipos,
        ];
    }   

    public function categoria(Request $request)
    {
        
        $cate = new pCFECategorias();
        $cate->titulo = $request->nombre;   
        $cate->CFE_id = '6'; 
        $cate->save();

        $categorias = pCFECategorias::where('CFE_id','=','6')->get();
        return [
            'categorias' => $categorias,
        ];
    } 
}
