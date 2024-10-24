<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\presupuestos;
use App\pVehiculos;
use App\pGenerales;
use App\pCategorias;
use App\pTipos;
use App\Productos;
use App\pCarrito;
use App\CodigoSat;
use App\OrdenEntrada2;

use App\FotosViejas2;
use App\FotosNuevas2;
use App\FotosInstaladas2;
use App\Acuse2;
use App\OrdenServicio2;
use App\FacturaXML2;
use App\FacturaPDF2;
use App\Factura;
use App\ReporteAnomalias2;
use Response;
use App\CorrectivosOrden2;
use App\ServicioOrden2;
use App\TipoServicioOrden2;
use App\Empresa;
use App\HojaConcepto;
use App\Concepto;

use DB;
use Illuminate\Support\Carbon;

class presupuestosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $contra = $request->contra;
        $criterio = $request->criterio;
        $categorias = pCategorias::get();
        $tipos = pTipos::get();
        $productos = CodigoSat::get();
        $contratos = Empresa::orderBy('nombre','asc')->get();
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;
        if ($fecha_inicio=='' || $fecha_final=='' ){
        if ($contra == '1'){
            $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area','presupuestos.empresa_id')
            ->where('empresas.id','=',$buscar)->orderBy('presupuestos.id', 'desc')->paginate(15);
            
        } else {   
        if ($buscar==''){
            $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area','presupuestos.empresa_id')
            ->orderBy('presupuestos.id', 'desc')->paginate(15);
        }
        else{
            $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestos.id', 'desc')->paginate(15);
        }
        }
    } else {
        $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
        ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
        ->join('empresas','presupuestos.empresa_id','=','empresas.id')
        ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
        'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
        'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
        'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
        ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area')
        ->whereBetween('presupuestos.created_at', [$request->fecha_inicio, $request->fecha_final])
        ->orderBy('presupuestos.id', 'desc')->paginate(30);
   
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
            'clientes' => $contratos,
        ];
    }

    public function tipo(Request $request)
    {
        $tipo = new pTipos();
        $tipo->tipo = $request->nombre;    
        $tipo->save();

        
        $tipos = pTipos::get();
        return [
            'tipos' => $tipos,
        ];
    }   

    public function categoria(Request $request)
    {
        $cate = new pCategorias();
        $cate->titulo = $request->nombre;    
        $cate->save();

        $categorias = pCategorias::get();
        return [
            'categorias' => $categorias,
        ];
    }   
  
 
    public function store(Request $request)
    {
       
  
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            $fechita = Carbon::parse($request->fecha)->format('Y-m-d H:m');


            $vehiculo = new pVehiculos();
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
            $generales = new pGenerales();
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

            
 
            
            $cotizacion = new presupuestos();
            $cotizacion->pVehiculos_id = $vehiculo->id;
            $cotizacion->pGenerales_id = $generales->id;
            $cotizacion->descripcionMO = $request->descripcionMO;
            $cotizacion->fechaDeVigencia = $request->fechaDeVigencia;
            $cotizacion->tiempo = $request->tiempo;
            $cotizacion->importe =$request->importe;
            $cotizacion->observaciones =$request->observaciones;
            $cotizacion->user_id = \Auth::user()->id;
            $cotizacion->ubicacion =$request->ubicacion;
            $cotizacion->area =$request->area;
            $cotizacion->empresa_id =$request->empresa_id;
            $cotizacion->save();   
            
            $coti = new ServicioOrden2();
            $coti->presupuesto_id = $cotizacion->id;
            $coti->preocorr_id = $request->preocorr_id;    
            $coti->ubicacion = $request->ubi;
            $coti->area = $request->area;
            $coti->save();


            if($request->preocorr_id == "2"){

                $detalles = $request->data;//Array de detalles
                foreach($detalles as $ep=>$det)
                {
                    $detalle = new CorrectivosOrden2();
                    $detalle->presupuesto_id = $cotizacion->id;
                    $detalle->correctivo_id = $det['code'];      
                    $detalle->save();
                }     

            } 
            if($request->preocorr_id == "1"){
                $ser = new TipoServicioOrden2();
                $ser->presupuesto_id = $cotizacion->id;
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
        $vehiculo = new pVehiculos();
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
        $generales = new pGenerales();
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

        $cotizacion = new presupuestos();
        $cotizacion = $cotizacion->find($request->id);
        $cotizacion->descripcionMO = $request->descripcionMO;
        $cotizacion->fechaDeVigencia = $request->fechaDeVigencia;
        $cotizacion->importe =$request->importe;
        $cotizacion->ubicacion =$request->ubicacion;
        $cotizacion->observaciones =$request->observaciones;
        $cotizacion->tdeentrega =$request->tdeentrega;
        $cotizacion->area =$request->area;
        $cotizacion->empresa_id =$request->empresa_id;
        $cotizacion->save();     
             
       
        return [
            'id'=> $vehiculo->id
        ];
    }

    public function selectTipos(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = pCategorias::select('id','num','titulo')->orderBy('id', 'asc')->get();
        return ['categorias' => $categorias];
    }

    public function selectCategorias(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = pTipos::select('id','tipo')->orderBy('id', 'asc')->get();
        return ['tipos' => $categorias];
    }

    public function factura(Request $request){
        if (!$request->ajax()) return redirect('/');
        $presupuesto = presupuestos::select('factura_id')->where('id','=',$request->id)->first();

        $factura = Factura::select('xml','pdf')
            ->where('facturas.id','=',$presupuesto->factura_id)->first();
        return [
            'xml' => $factura->xml,
            'pdf' => $factura->pdf
                ];
    }

    public function pdf(Request $request,$id){

        $cotizacion11 = presupuestos::select('presupuestos.empresa_id')
        ->where('presupuestos.id','=',$id)->orderBy('presupuestos.id', 'desc')->take(1)->get();

    if($cotizacion11[0]['empresa_id'] == null){

        $cotizacion = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('recepcion_vehicular','pGenerales.NSolicitud','=','recepcion_vehicular.folioNum')
            ->join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.tdeentrega','presupuestos.area','empresas.logo')
            ->where('presupuestos.id','=',$id)->orderBy('presupuestos.id', 'desc')->take(1)->get();
    } else {
        $cotizacion = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
        ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
        ->join('empresas','presupuestos.empresa_id','=','empresas.id')
        ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
        'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
        'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
        'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.tdeentrega','presupuestos.area','empresas.logo')
        ->where('presupuestos.id','=',$id)->orderBy('presupuestos.id', 'desc')->take(1)->get();
    }

        $detalles = pCarrito::join('pConceptos','pCarrito.pConcepto_id','=','pConceptos.id')
        ->join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
        ->join('presupuestos','pCarrito.presupuesto_id','=','presupuestos.id')
        ->select('pCarrito.id','pConceptos.descripcion','pConceptos.num','pCarrito.cantidad','pCarrito.precio','pCategorias.titulo','pCategorias.num as nuc')
        ->where('pCarrito.presupuesto_id','=',$id)
        ->orderBy('pCarrito.id', 'desc')->get();

        return \View::make('pdf.presupuesto2', compact('cotizacion', 'detalles'))->render();
       // if ($m == 1){
       // $pdf = \PDF::loadView('pdf.cotizacion',['cotizacion'=>$cotizacion,'detalles'=>$detalles]);
       // return $pdf->download('cotizacion-'.$numventa[0]->id.'.pdf');
       // } else if ($m == 2) {
      //  $view =  \View::make('pdf.cotizacion', compact('cotizacion', 'detalles'))->render();
      //  $pdf = \App::make('dompdf.wrapper');
      //  $pdf->loadHTML($view);
      //  return $pdf->stream('cotizacion');}

      

    }

    public function pdfConceptos(Request $request,$id){

        $cotizacion = HojaConcepto::join('recepcion_vehicular','hoja_conceptos.id_recepcion','=','recepcion_vehicular.id')
        ->join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
        ->join('vehiculos','recepcion_vehicular.vehiculo_id','=','vehiculos.id')
        ->join('marcas','vehiculos.marca_id','=','marcas.id')
        ->join('modelos','vehiculos.modelo_id','=','modelos.id')
        ->select('hoja_conceptos.id','recepcion_vehicular.folioNum as NSolicitud','recepcion_vehicular.fecha as FechaAlta','empresas.logo','marcas.nombre as marca','modelos.nombre as modelo',
        'vehiculos.anio as ano','vehiculos.placas','vehiculos.vim as vin','vehiculos.no_economico as identificador','recepcion_vehicular.km_entrada as kilometraje','recepcion_vehicular.orden_seguimiento as OrdenServicio'
        ,'recepcion_vehicular.folio as area')
        ->where('hoja_conceptos.id','=',$id)->orderBy('hoja_conceptos.id', 'desc')->take(1)->get();

        $detalles = Concepto::select('id','descripcion','num_concepto as cantidad','subtotal_costos as precio','remplazar as titulo')
        ->where('id_hoja_conceptos','=',$id)
        ->orderBy('id', 'desc')->get();

        return \View::make('pdf.presupuesto2', compact('cotizacion', 'detalles'))->render();
       // if ($m == 1){
       // $pdf = \PDF::loadView('pdf.cotizacion',['cotizacion'=>$cotizacion,'detalles'=>$detalles]);
       // return $pdf->download('cotizacion-'.$numventa[0]->id.'.pdf');
       // } else if ($m == 2) {
      //  $view =  \View::make('pdf.cotizacion', compact('cotizacion', 'detalles'))->render();
      //  $pdf = \App::make('dompdf.wrapper');
      //  $pdf->loadHTML($view);
      //  return $pdf->stream('cotizacion');}

      

    }
    public function pdfcfe(Request $request,$id){

        $cotizacion11 = presupuestos::select('presupuestos.empresa_id')
            ->where('presupuestos.id','=',$id)->orderBy('presupuestos.id', 'desc')->take(1)->get();

        if($cotizacion11[0]['empresa_id'] == null){
            $cotizacion = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('recepcion_vehicular','pGenerales.NSolicitud','=','recepcion_vehicular.folioNum')
            ->join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.tdeentrega','presupuestos.area','empresas.logo')
            ->where('presupuestos.id','=',$id)->orderBy('presupuestos.id', 'desc')->take(1)->get();
        } else {
            $cotizacion = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.tdeentrega','presupuestos.area','empresas.logo')
            ->where('presupuestos.id','=',$id)->orderBy('presupuestos.id', 'desc')->take(1)->get();
        }

        

        $detalles = pCarrito::join('pConceptos','pCarrito.pConcepto_id','=','pConceptos.id')
        ->join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
        ->join('presupuestos','pCarrito.presupuesto_id','=','presupuestos.id')
        ->select('pCarrito.id','pConceptos.descripcion','pConceptos.num','pCarrito.cantidad','pCarrito.precio_v as precio','pCategorias.titulo','pCategorias.num as nuc')
        ->where('pCarrito.presupuesto_id','=',$id)
        ->orderBy('pCarrito.id', 'desc')->get();

        return \View::make('pdf.presupuesto2', compact('cotizacion', 'detalles'))->render();
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

        $cotizacion11 = presupuestos::select('presupuestos.empresa_id')
            ->where('presupuestos.id','=',$id)->orderBy('presupuestos.id', 'desc')->take(1)->get();

        if($cotizacion11[0]['empresa_id'] == null){ 
            $cotizacion = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('recepcion_vehicular','pGenerales.NSolicitud','=','recepcion_vehicular.folioNum')
            ->join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.tdeentrega','empresas.logo')
            ->where('presupuestos.id','=',$id)->orderBy('presupuestos.id', 'desc')->take(1)->get();

        } else {

            $cotizacion = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.tdeentrega','empresas.logo')
            ->where('presupuestos.id','=',$id)->orderBy('presupuestos.id', 'desc')->take(1)->get();
        }

       

        $detalles = pCarrito::join('pConceptos','pCarrito.pConcepto_id','=','pConceptos.id')
        ->join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
        ->join('presupuestos','pCarrito.presupuesto_id','=','presupuestos.id')
        ->select('pCarrito.id','pConceptos.descripcion','pConceptos.num','pCarrito.cantidad','pCarrito.precio_v as precio','pCategorias.titulo','pCategorias.num as nuc')
        ->where('pCarrito.presupuesto_id','=',$id)
        ->orderBy('pCarrito.id', 'desc')->get();

        return \View::make('pdf.presupuestoAcuse2', compact('cotizacion', 'detalles'))->render();
       // if ($m == 1){
       // $pdf = \PDF::loadView('pdf.cotizacion',['cotizacion'=>$cotizacion,'detalles'=>$detalles]);
       // return $pdf->download('cotizacion-'.$numventa[0]->id.'.pdf');
       // } else if ($m == 2) {
      //  $view =  \View::make('pdf.cotizacion', compact('cotizacion', 'detalles'))->render();
      //  $pdf = \App::make('dompdf.wrapper');
      //  $pdf->loadHTML($view);
      //  return $pdf->stream('cotizacion');}

      

    }
    public function guardarEntrada(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new OrdenEntrada2();
            $cotizacion->presupuesto_id = $request->id;
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

    public function updatearchivos(Request $request)
    {
       
        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/fotosviejas/'.$request->doc;
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

    public function verOrdenEntrada(Request $request){

        $fotos = OrdenEntrada2::select('archivo')
            ->where('presupuesto_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
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
    public function guardarFotoVieja(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new FotosViejas2();
            $cotizacion->presupuesto_id = $request->id;
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
 
            $cotizacion = new FotosNuevas2();
            $cotizacion->presupuesto_id = $request->id;
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
 
            $cotizacion = new FotosInstaladas2();
            $cotizacion->presupuesto_id = $request->id;
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
 
            $cotizacion = new ReporteAnomalias2();
            $cotizacion->presupuesto_id = $request->id;
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
 
            $cotizacion = new FacturaPDF2();
            $cotizacion->presupuesto_id = $request->id;
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
 
            $cotizacion = new FacturaXML2();
            $cotizacion->presupuesto_id = $request->id;
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
 
            $cotizacion = new Acuse2();
            $cotizacion->presupuesto_id = $request->id;
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
 
            $cotizacion = new OrdenServicio2();
            $cotizacion->presupuesto_id = $request->id;
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

        $fotos = FotosViejas2::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verReporteAnomalias(Request $request){

        $fotos = ReporteAnomalias2::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFotosNuevas(Request $request){

        $fotos = FotosNuevas2::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFotosInstaladas(Request $request){

        $fotos = FotosInstaladas2::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verAcuse(Request $request){

        $fotos = Acuse2::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verOrdenServicio(Request $request){

        $fotos = OrdenServicio2::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFacturaXML(Request $request){

        $fotos = FacturaXML2::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }
    public function verFacturaPDF(Request $request){

        $fotos = FacturaPDF2::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function cambioStatus(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new presupuestos();
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

    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
         
        $detalles =  pCarrito::join('pConceptos','pCarrito.pConcepto_id','=','pConceptos.id')
        ->join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
        ->join('presupuestos','pCarrito.presupuesto_id','=','presupuestos.id')
        ->select('pCarrito.id','pCarrito.pConcepto_id as idarticulo','pConceptos.descripcion','pConceptos.num','pCarrito.cantidad','pCarrito.precio_v as precio','pCategorias.titulo','pCategorias.num as nuc','pCarrito.presupuesto_id')
        ->where('pCarrito.presupuesto_id','=',$id)
        ->orderBy('pCarrito.id', 'desc')->get();

         
        return [
           
            'detalles' => $detalles
        ];
    }

    public function desactivar(Request $request)
    {
       
     
        $cotizacion = presupuestos::findOrFail($request->id);
       

        $so22 = ServicioOrden2::where('presupuesto_id','=',$request->id)->count();
        if($so22 == 0){
           
        } else {
        $so = ServicioOrden2::select('id','preocorr_id')->where('presupuesto_id','=',$request->id)->get();
        $so1 = ServicioOrden2::findOrFail($so[0]['id']);
        $estado0= $so1->delete();
     
        if($so[0]['preocorr_id'] == "2"){
        $co = CorrectivosOrden2::select('id')->where('presupuesto_id','=',$request->id)->get();
        $co1 = CorrectivosOrden2::findOrFail($co[0]['id']);
        $estado1= $co1->delete();
        }
        if($so[0]['preocorr_id'] == "1"){
        $ts = TipoServicioOrden2::select('id')->where('presupuesto_id','=',$request->id)->get();
        $ts1 = TipoServicioOrden2::findOrFail($ts[0]['id']);
        $estado2= $ts1->delete();
        }

         }
         $sca22 = pCarrito::where('presupuesto_id','=',$request->id)->count();
         if($sca22 == 0){
         } else {
        $carro = pCarrito::where('presupuesto_id','=',$request->id)->get();
        $carro33 = pCarrito::findOrFail($carro[0]['id']);
        $estado222= $carro33->delete();
         }
        //Eliminamos los clientes de esa empresa
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }

    public function indexStart(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $contra = $request->contra;
        $criterio = $request->criterio;
        $categorias = pCategorias::get();
        $tipos = pTipos::get();
        $productos = CodigoSat::get();
        $contratos = Empresa::get();
        if ($contra == '1'){
            $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area')
            ->where('empresas.id','=',$buscar)->where('presupuestos.user_id','=',\Auth::user()->id)->orderBy('presupuestos.id', 'desc')->paginate(15);
            
        } else {   
        if ($buscar==''){
            $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area')
            ->orderBy('presupuestos.id', 'desc')->where('presupuestos.user_id','=',\Auth::user()->id)->paginate(15);
        }
        else{
            $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area')
            ->where($criterio, 'like', '%'. $buscar . '%')->where('presupuestos.user_id','=',\Auth::user()->id)->orderBy('presupuestos.id', 'desc')->paginate(15);
        }
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
            'clientes' => $contratos,
        ];
    }


    public function exel(Request $request)
    {
       
       
 
        $buscar = $request->buscar;
        $contra = $request->contra;
        $criterio = $request->criterio;
        $categorias = pCategorias::get();
        $tipos = pTipos::get();
        $productos = CodigoSat::get();
        $contratos = Empresa::orderBy('nombre','asc')->get();
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;
        if ($fecha_inicio=='' || $fecha_final=='' ){
        if ($contra == '1'){
            $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area','presupuestos.empresa_id')
            ->where('empresas.id','=',$buscar)->orderBy('presupuestos.id', 'desc')->paginate(15);
            
        } else {   
        if ($buscar==''){
            $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area','presupuestos.empresa_id')
            ->orderBy('presupuestos.id', 'desc')->paginate(15);
        }
        else{
            $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
            ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
            ->join('empresas','presupuestos.empresa_id','=','empresas.id')
            ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
            'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
            'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
            'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
            ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestos.id', 'desc')->paginate(15);
        }
        }
    } else {
        $cotizaciones = presupuestos::join('pVehiculos','presupuestos.pVehiculos_id','=','pVehiculos.id')
        ->join('pGenerales','presupuestos.pGenerales_id','=','pGenerales.id')
        ->join('empresas','presupuestos.empresa_id','=','empresas.id')
        ->select('presupuestos.id','pGenerales.NSolicitud','pGenerales.FechaAlta','pGenerales.OrdenServicio',
        'pGenerales.KmDeIngreso','pVehiculos.identificador','pVehiculos.kilometraje','pVehiculos.marca',
        'pVehiculos.modelo','pVehiculos.ano','pVehiculos.placas','pVehiculos.vin','pGenerales.ClienteYRazonSocial',
        'pGenerales.Mail','pGenerales.Telefono','pGenerales.Conductor','presupuestos.created_at','presupuestos.observaciones','presupuestos.status','pVehiculos.id as pVehiculos_id','pGenerales.id as pGenerales_id'
        ,'presupuestos.descripcionMO','presupuestos.importe','presupuestos.ubicacion','presupuestos.tdeentrega','presupuestos.area')
        ->whereBetween('presupuestos.created_at', [$request->fecha_inicio, $request->fecha_final])
        ->orderBy('presupuestos.id', 'desc')->paginate(30);
   
    }

    
         
    return \View::make('pdf.exelExport')->with('detalles',$cotizaciones);
    }
    

    
 
  
}
