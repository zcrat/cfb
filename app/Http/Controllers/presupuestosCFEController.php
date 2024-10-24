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

class presupuestosCFEController extends Controller
{
    public function index(Request $request)
    {

        $id = \Auth::user()->id;

        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $categorias = pCFECategorias::get();
        $tipos = pCFETipos::get();
        $productos = CodigoSat::get();
        $contratos = Contratos::get();

        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;
        if ($fecha_inicio=='' || $fecha_final=='' ){
        if ($buscar==''){
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area')
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('presupuestosCFE.user_id','=',$id)
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('presupuestosCFE.user_id','=',$id)
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
        }
        } else {
            $cotizaciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area')
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('presupuestosCFE.user_id','=',$id)
            ->whereBetween('presupuestosCFE.created_at', [$request->fecha_inicio, $request->fecha_final])
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
        $criterio = $request->criterio;
        $categorias = pCFECategorias::where('CFE_id','=','1')->get();
        $tipos = pCFETipos::where('CFE_id','=','1')->get();
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$buscar)->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
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
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato','presupuestosCFE.factura_id','presupuestosCFE.tramite')
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestosCFE.id', 'desc')->paginate(10);
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->whereBetween('presupuestosCFE.created_at', [$request->fecha_inicio, $request->fecha_final])
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
        $categorias = pCFECategorias::where('CFE_id','=','1')->get();
        $tipos = pCFETipos::where('CFE_id','=','1')->get();
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')->where('contratos.id','=',$idcontrato)->orderBy('presupuestosCFE.id', 'desc')->paginate(40);
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
        $categorias = pCFECategorias::where('CFE_id','=','1')->get();
        $tipos = pCFETipos::where('CFE_id','=','1')->get();
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->where('tipo_servicio_orden.tipo_servicio','=',$tipo_servicio)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->where('correctivos_orden.correctivo_id','=',$tipo_correctivo)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEVehiculos.'.$request->criterios,'=',$request->buscar)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
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

    public function exel(Request $request){


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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->where('tipo_servicio_orden.tipo_servicio','=',$tipo_servicio)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->orderBy('presupuestosCFE.id', 'desc')->get();
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->orderBy('presupuestosCFE.id', 'desc')->get();
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->where('correctivos_orden.correctivo_id','=',$tipo_correctivo)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->orderBy('presupuestosCFE.id', 'desc')->get();
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('servicio_orden.preocorr_id','=',$servicio)
            ->where('servicio_orden.ubicacion','=',$ubicacion)
            ->where('servicio_orden.area','=',$criterio)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->orderBy('presupuestosCFE.id', 'desc')->get();
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
            ->where('presupuestosCFE.CFE_id','=','1')
            ->where('contratos.id','=',$idcontrato)
            ->where('pCFEVehiculos.'.$request->criterios,'=',$request->buscar)
            ->whereBetween('pCFEGenerales.FechaAlta', [$request->finicio, $request->ffinal])
            ->orderBy('presupuestosCFE.id', 'desc')->get();
        }

    

       



        return \View::make('pdf.exelExport')->with('envios',$cotizaciones);

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
            $cotizacion->CFE_id='1';
            $cotizacion->save();   
            
            $coti = new ServicioOrden();
            $coti->presupuestoCFE_id = $cotizacion->id;
            $coti->preocorr_id = $request->preocorr_id;    
            $coti->ubicacion = $request->ubi;
            $coti->area = $request->area;
            $coti->save();


            if($request->preocorr_id == "2"){

                $detalles = $request->data;//Array de detalles
                foreach($detalles as $ep=>$det)
                {
                    $detalle = new CorrectivosOrden();
                    $detalle->presupuestoCFE_id = $cotizacion->id;
                    $detalle->correctivo_id = $det['id'];      
                    $detalle->save();
                }     

            } 
            if($request->preocorr_id == "1"){
                $ser = new TipoServicioOrden();
                $ser->presupuestoCFE_id = $cotizacion->id;
                $ser->tipo_servicio = $request->tipo_servicio;
                $ser->kilometros = $request->kilome;
                $ser->save();

            }

          
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
    
  
        if (!$request->ajax()) return redirect('/');
        $fechita = Carbon::parse($request->fecha)->format('Y-m-d H:m');
        $vehiculo = new pCFEVehiculos();
        $vehiculo = $vehiculo->find($request->pCFEVehiculos_id);
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
        $generales = $generales->find($request->pCFEGenerales_id);
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
        $cotizacion = $cotizacion->find($request->id);
        $cotizacion->descripcionMO = $request->descripcionMO;
        $cotizacion->fechaDeVigencia = $request->fechaDeVigencia;
        $cotizacion->importe =$request->importe;
        $cotizacion->importep =$request->importep;
        $cotizacion->ubicacion =$request->ubicacion;
        $cotizacion->observaciones =$request->observaciones;
        $cotizacion->tdeentrega =$request->tdeentrega;
        $cotizacion->area =$request->area;
        $cotizacion->save();    
        
     
             
       
        return [
            'id'=> $vehiculo->id
        ];
    }

    public function selectTipos(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = pCFECategorias::select('id','num','titulo')
        ->where('CFE_id','=','1')
        ->orderBy('id', 'asc')->get();
        return ['categorias' => $categorias];
    }

    public function selectCategorias(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = pCFETipos::select('id','tipo')
        ->where('CFE_id','=','1')
        ->orderBy('id', 'asc')->get();
        return ['tipos' => $categorias];
    }

    public function factura(Request $request){
        if (!$request->ajax()) return redirect('/');
        $presupuesto = presupuestosCFE::select('factura_id')->where('id','=',$request->id)->first();

        $factura = Factura::select('xml','pdf')
            ->where('facturas.id','=',$presupuesto->factura_id)->first();
        return [
            'xml' => $factura->xml,
            'pdf' => $factura->pdf
                ];
    }

    public function pdf(Request $request,$id){

        $cotizacion = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','presupuestosCFE.CFE_id')
            ->where('presupuestosCFE.id','=',$id)->orderBy('presupuestosCFE.id', 'desc')->take(1)->get();

        $detalles = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
        ->join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
        ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
        ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFEConceptos.num','pCFECarrito.cantidad','pCFECarrito.precio','pCFECategorias.titulo','pCFECategorias.num as nuc')
        ->where('pCFECarrito.presupuestoCFE_id','=',$id)
        ->orderBy('pCFECarrito.id', 'desc')->get();

        if($cotizacion[0]->CFE_id == 6){
            return \View::make('pdf.presupuestoeco', compact('cotizacion', 'detalles'))->render();
        } else {
            return \View::make('pdf.presupuesto', compact('cotizacion', 'detalles'))->render();
            
        }
        

        
       // if ($m == 1){
       // $pdf = \PDF::loadView('pdf.cotizacion',['cotizacion'=>$cotizacion,'detalles'=>$detalles]);
       // return $pdf->download('cotizacion-'.$numventa[0]->id.'.pdf');
       // } else if ($m == 2) {
      //  $view =  \View::make('pdf.cotizacion', compact('cotizacion', 'detalles'))->render();
      //  $pdf = \App::make('dompdf.wrapper');
      //  $pdf->loadHTML($view);
      //  return $pdf->stream('cotizacion');}

      

    }
    public function tipo(Request $request)
    {
        $tipo = new pCFETipos();
        $tipo->tipo = $request->nombre; 
        $tipo->CFE_id = '1';   
        $tipo->save();

        
        $tipos = pCFETipos::where('CFE_id','=','1')->get();
        return [
            'tipos' => $tipos,
        ];
    }   

    public function categoria(Request $request)
    {
        
        $cate = new pCFECategorias();
        $cate->titulo = $request->nombre;   
        $cate->CFE_id = '1'; 
        $cate->save();

        $categorias = pCFECategorias::where('CFE_id','=','1')->get();
        return [
            'categorias' => $categorias,
        ];
    } 
    
    public function pdfcfe(Request $request,$id){

        $cotizacion = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','presupuestosCFE.CFE_id')
            ->where('presupuestosCFE.id','=',$id)->orderBy('presupuestosCFE.id', 'desc')->take(1)->get();

        $detalles = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
        ->join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
        ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
        ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFEConceptos.num','pCFECarrito.cantidad','pCFECarrito.precio_v as precio','pCFECategorias.titulo','pCFECategorias.num as nuc')
        ->where('pCFECarrito.presupuestoCFE_id','=',$id)
        ->orderBy('pCFECarrito.id', 'desc')->get();


      
        if($cotizacion[0]->CFE_id == 6){
            return \View::make('pdf.presupuestoeco', compact('cotizacion', 'detalles'))->render();
        } else {
            return \View::make('pdf.presupuesto', compact('cotizacion', 'detalles'))->render();
            
        }
    
       // if ($m == 1){
       // $pdf = \PDF::loadView('pdf.cotizacion',['cotizacion'=>$cotizacion,'detalles'=>$detalles]);
       // return $pdf->download('cotizacion-'.$numventa[0]->id.'.pdf');
       // } else if ($m == 2) {
      //  $view =  \View::make('pdf.cotizacion', compact('cotizacion', 'detalles'))->render();
      //  $pdf = \App::make('dompdf.wrapper');
      //  $pdf->loadHTML($view);
      //  return $pdf->stream('cotizacion');}

      

    }

    public function pdfacuse(Request $request,$id){

        $cotizacion = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area')
            ->where('presupuestosCFE.id','=',$id)->orderBy('presupuestosCFE.id', 'desc')->take(1)->get();

        $detalles = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
        ->join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
        ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
        ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFEConceptos.num','pCFECarrito.cantidad','pCFECarrito.precio_v as precio','pCFECategorias.titulo','pCFECategorias.num as nuc')
        ->where('pCFECarrito.presupuestoCFE_id','=',$id)
        ->orderBy('pCFECarrito.id', 'desc')->get();

        return \View::make('pdf.presupuestoAcuse', compact('cotizacion', 'detalles'))->render();
       // if ($m == 1){
       // $pdf = \PDF::loadView('pdf.cotizacion',['cotizacion'=>$cotizacion,'detalles'=>$detalles]);
       // return $pdf->download('cotizacion-'.$numventa[0]->id.'.pdf');
       // } else if ($m == 2) {
      //  $view =  \View::make('pdf.cotizacion', compact('cotizacion', 'detalles'))->render();
      //  $pdf = \App::make('dompdf.wrapper');
      //  $pdf->loadHTML($view);
      //  return $pdf->stream('cotizacion');}

      

    }
    public function updatearchivos(Request $request)
    {
       
        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/fotosviejas/'.$request->doc;
            $exists = is_file($file);

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'doc';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/fotosviejas/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }

    public function updatearchivos2(Request $request)
    {

        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/reporteanomalias/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'doc';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/reporteanomalias/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }

    public function updatearchivos3(Request $request)
    {



       
        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/fotosnuevas/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'doc';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/fotosnuevas/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }
    public function updatearchivos4(Request $request)
    {



       
        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/fotosinstaladas/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'doc';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/fotosinstaladas/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }

    public function updatearchivos5(Request $request)
    {



       
        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/acuse/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'doc';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/acuse/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }
    public function updatearchivos6(Request $request)
    {



       
        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/facturaxml/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'xml'))
                $extension = 'xml';
            else 
                $extension = 'xml';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/facturaxml/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }
    public function updatearchivos7(Request $request)
    {



       
        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/facturapdf/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'doc';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/facturapdf/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }
    public function updatearchivos8(Request $request)
    {



       
        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/ordenservicio/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'doc';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/ordenservicio/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }

    public function obtenerDetallesmulti(Request $request){

            

       
        if (!$request->ajax()) return redirect('/');
 

        $id = $request->ides;//Array de detalles
        //Recorro todos los elementos

        
      
        $pila = [];

    
        foreach($id as $ep=>$det)
        {
           
          
            $detalles = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.identificador as economico','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.id','=',$det)->get();

            array_push($pila,$detalles[0]);  
        } 
         
        
       

        return [
           
             'detalles' => $pila
        ];
    }


    public function obtenerDetallesmultiSave(Request $request){

            
       
       
        if (!$request->ajax()) return redirect('/');
 

        $id = $request->id;//Array de detalles
        //Recorro todos los elementos

           

        $detalles_todo = FacturasSaveDetalle::where('facturas_save_detalle.facturas_save_id','=',$id)->orderBy('facturas_save_detalle.id', 'asc')
            ->paginate(1000);

   
      
        $pila = [];

    
        foreach($detalles_todo as $ep=>$det)
        {
           
        
          
            $detalles = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.identificador as economico','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.id','=',$det['presupuesto_id'])->get();

            array_push($pila,$detalles[0]);  
        } 
         
        
       

        return [
           
             'detalles' => $pila
        ];
    }


    public function obtenerDetallesmultiExel(Request $request){

            
        $detalles_todo = FacturasSaveDetalle::where('facturas_save_detalle.facturas_save_id','=',$request->id)->orderBy('facturas_save_detalle.id', 'asc')
            ->paginate(1000);


        $pila = [];    
        foreach($detalles_todo as $ep=>$det)
        {
          
            $detalles = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.identificador as economico','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area','contratos.numero as contrato')
            ->where('presupuestosCFE.id','=',$det['presupuesto_id'])->get();

            array_push($pila,$detalles[0]);  
        }

        return \View::make('pdf.exelExport')->with('detalles',$pila);
    }

    public function updatearchivos9(Request $request)
    {



       
        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/ordenentrada/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'doc';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/ordenentrada/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }
    public function guardarFotoVieja(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FotosViejas();
            $cotizacion->presupuestoCFE_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarFotoNueva(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FotosNuevas();
            $cotizacion->presupuestoCFE_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarFotoInstalada(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FotosInstaladas();
            $cotizacion->presupuestoCFE_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarReporteAnomalias(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new ReporteAnomalias();
            $cotizacion->presupuestoCFE_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarFacturaPDF(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FacturaPDF();
            $cotizacion->presupuestoCFE_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarFacturaXML(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FacturaXML();
            $cotizacion->presupuestoCFE_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarAcuse(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new Acuse();
            $cotizacion->presupuestoCFE_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarOrdenServicio(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new OrdenServicio();
            $cotizacion->presupuestoCFE_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function guardarEntrada(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new OrdenEntrada();
            $cotizacion->presupuestoCFE_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function verFotosViejas(Request $request){

        $fotos = FotosViejas::select('archivo')
            ->where('presupuestoCFE_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verReporteAnomalias(Request $request){

        $fotos = ReporteAnomalias::select('archivo')
            ->where('presupuestoCFE_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFotosNuevas(Request $request){

        $fotos = FotosNuevas::select('archivo')
            ->where('presupuestoCFE_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFotosInstaladas(Request $request){

        $fotos = FotosInstaladas::select('archivo')
            ->where('presupuestoCFE_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verAcuse(Request $request){

        $fotos = Acuse::select('archivo')
            ->where('presupuestoCFE_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verOrdenServicio(Request $request){

        $fotos = OrdenServicio::select('archivo')
            ->where('presupuestoCFE_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verOrdenEntrada(Request $request){

        $fotos = OrdenEntrada::select('archivo')
            ->where('presupuestoCFE_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFacturaXML(Request $request){

        $fotos = FacturaXML::select('archivo')
            ->where('presupuestoCFE_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }
    public function verFacturaPDF(Request $request){

        $fotos = FacturaPDF::select('archivo')
            ->where('presupuestoCFE_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function cambioStatus(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new presupuestosCFE();
            $cotizacion = $cotizacion->find($request->id);
            $cotizacion->status = $request->status;
            $cotizacion->save();  
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function tramitado(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new presupuestosCFE();
            $cotizacion = $cotizacion->find($request->id);
            $cotizacion->tramite = $request->tramitado;
            $cotizacion->save();  
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
         
        $detalles =  pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
        ->join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
        ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
        ->select('pCFECarrito.id','pCFECarrito.pCFEConcepto_id as idarticulo','pCFEConceptos.descripcion','pCFEConceptos.num','pCFECarrito.cantidad','pCFECarrito.precio_v as precio','pCFECategorias.titulo','pCFECategorias.num as nuc','pCFECarrito.presupuestoCFE_id')
        ->where('pCFECarrito.presupuestoCFE_id','=',$id)
        ->orderBy('pCFECarrito.id', 'desc')->get();

         
        return [
           
            'detalles' => $detalles
        ];
    }

    public function desactivar(Request $request)
    {
        
     
        $cotizacion = presupuestosCFE::findOrFail($request->id);
       
        $so22 = ServicioOrden::where('presupuestoCFE_id','=',$request->id)->count();
        if($so22 == 0){

        } else {
        $so = ServicioOrden::select('id','preocorr_id')->where('presupuestoCFE_id','=',$request->id)->get();
        $so1 = ServicioOrden::findOrFail($so[0]['id']);
        $estado0= $so1->delete();
     
        if($so[0]['preocorr_id'] == "2"){
        $co = CorrectivosOrden::select('id')->where('presupuestoCFE_id','=',$request->id)->get();
        $co1 = CorrectivosOrden::findOrFail($co[0]['id']);
        $estado1= $co1->delete();
        }
        if($so[0]['preocorr_id'] == "1"){
        $ts = TipoServicioOrden::select('id')->where('presupuestoCFE_id','=',$request->id)->get();
        $ts1 = TipoServicioOrden::findOrFail($ts[0]['id']);
        $estado2= $ts1->delete();
        }

         }
        $concep = pCFECarrito::where('presupuestoCFE_id','=',$request->id)->count();
        if($concep == 0){

        } else {
            $carro = pCFECarrito::where('presupuestoCFE_id','=',$request->id)->get();
            $carro33 = pCFECarrito::findOrFail($carro[0]['id']);
            $estado222= $carro33->delete();
        }
       
        //Eliminamos los clientes de esa empresa
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }
    

    
 
  
}
