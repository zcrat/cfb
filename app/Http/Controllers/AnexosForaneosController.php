<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\anexosForaneos;
use App\anexosFVehiculos;
use App\anexosFGenerales;
use App\anexosFCategorias;
use App\anexosFTipos;
use App\Productos;
use App\anexosFCarrito;
use App\CodigoSat;
use App\anexosFOE;

use App\anexosFFotosViejas;
use App\anexosFFotosNuevas;
use App\AnexosFFotosInstaladas;
use App\AnexosFAcuses;
use App\AnexosFOS;
use App\AnexosFXML;
use App\AnexosFPDF;
use App\Factura;
use App\anexosFRA;
use Response;
use App\AnexosFCO;
use App\AnexosFSO;
use App\AnexosFTSO;
use App\Empresa;

use DB;
use Illuminate\Support\Carbon;

class AnexosForaneosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $contra = $request->contra;
        $criterio = $request->criterio;
        $eco = $request->eco_id;
        $categorias = anexosFCategorias::orderBy('titulo', 'asc')->get();
        $tipos = anexosFTipos::orderBy('tipo', 'asc')->get();
        $productos = CodigoSat::get();
        $contratos = Empresa::orderBy('nombre','asc')->get();
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;
        if ($fecha_inicio=='' || $fecha_final=='' ){
        if ($contra == '1'){
            $cotizaciones = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.status','anexosFVehiculos.id as pVehiculos2023_id','anexosFGenerales.id as pGenerales2023_id'
            ,'anexosforaneos.descripcionMO','anexosforaneos.importe','anexosforaneos.ubicacion','anexosforaneos.tdeentrega','anexosforaneos.area','anexosforaneos.empresa_id')
            ->where('anexosforaneos.eco_id','=',$eco)->where('empresas.id','=',$buscar)->orderBy('anexosforaneos.id', 'desc')->paginate(15);
            
        } else {   
        if ($buscar==''){
            $cotizaciones = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.status','anexosFVehiculos.id as pVehiculos2023_id','anexosFGenerales.id as pGenerales2023_id'
            ,'anexosforaneos.descripcionMO','anexosforaneos.importe','anexosforaneos.ubicacion','anexosforaneos.tdeentrega','anexosforaneos.area','anexosforaneos.empresa_id')
            ->where('anexosforaneos.eco_id','=',$eco)->orderBy('anexosforaneos.id', 'desc')->paginate(15);
        }
        else{
            $cotizaciones = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.status','anexosFVehiculos.id as pVehiculos2023_id','anexosFGenerales.id as pGenerales2023_id'
            ,'anexosforaneos.descripcionMO','anexosforaneos.importe','anexosforaneos.ubicacion','anexosforaneos.tdeentrega','anexosforaneos.area')
            ->where('anexosforaneos.eco_id','=',$eco)->where($criterio, 'like', '%'. $buscar . '%')->orderBy('anexosforaneos.id', 'desc')->paginate(15);
        }
        }
    } else {
        $cotizaciones = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.status','anexosFVehiculos.id as pVehiculos2023_id','anexosFGenerales.id as pGenerales2023_id'
            ,'anexosforaneos.descripcionMO','anexosforaneos.importe','anexosforaneos.ubicacion','anexosforaneos.tdeentrega','anexosforaneos.area')
            ->where('anexosforaneos.eco_id','=',$eco)->whereBetween('anexosforaneos.created_at', [$request->fecha_inicio, $request->fecha_final])
            ->orderBy('anexosforaneos.id', 'desc')->paginate(30);
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
        $tipo = new anexosFTipos();
        $tipo->tipo = $request->nombre;    
        $tipo->save();

        
        $tipos = anexosFTipos::get();
        return [
            'tipos' => $tipos,
        ];
    }   

    public function categoria(Request $request)
    {
        $cate = new anexosFCategorias();
        $cate->titulo = $request->nombre;    
        $cate->save();

        $categorias = anexosFCategorias::get();
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


            $vehiculo = new anexosFVehiculos();
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
            $generales = new anexosFGenerales();
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

            
 
            
            $cotizacion = new anexosForaneos();
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
            $cotizacion->eco_id =$request->eco_id;
            $cotizacion->save();   
            
            // $coti = new AnexosFSO();
            // $coti->presupuesto_id = $cotizacion->id;
            // $coti->preocorr_id = $request->preocorr_id;    
            // $coti->ubicacion = $request->ubi;
            // $coti->area = $request->area;
            // $coti->save();


            // if($request->preocorr_id == "2"){

            //     $detalles = $request->data;//Array de detalles
            //     foreach($detalles as $ep=>$det)
            //     {
            //         $detalle = new AnexosFCO();
            //         $detalle->presupuesto_id = $cotizacion->id;
            //         $detalle->correctivo_id = $det['code'];      
            //         $detalle->save();
            //     }     

            // } 
            // if($request->preocorr_id == "1"){
            //     $ser = new AnexosFTSO();
            //     $ser->presupuesto_id = $cotizacion->id;
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

    public function update(Request $request)
    {

        if (!$request->ajax()) return redirect('/');
        $fechita = Carbon::parse($request->fecha)->format('Y-m-d H:m');
        $vehiculo = new anexosFVehiculos();
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
        $generales = new anexosFGenerales();
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

        $cotizacion = new anexosForaneos();
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
        $categorias = anexosFCategorias::select('id','num','titulo')->orderBy('id', 'asc')->get();
        return ['categorias' => $categorias];
    }

    public function selectCategorias(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = anexosFTipos::select('id','tipo')->orderBy('id', 'asc')->get();
        return ['tipos' => $categorias];
    }

    public function factura(Request $request){
        if (!$request->ajax()) return redirect('/');
        $presupuesto = anexosForaneos::select('factura_id')->where('id','=',$request->id)->first();

        $factura = Factura::select('xml','pdf')
            ->where('facturas.id','=',$presupuesto->factura_id)->first();
        return [
            'xml' => $factura->xml,
            'pdf' => $factura->pdf
                ];
    }

    public function pdf(Request $request,$id){

     

        $cotizacion11 = anexosForaneos::select('anexosforaneos.empresa_id','anexosforaneos.eco_id')
        ->where('anexosforaneos.id','=',$id)->orderBy('anexosforaneos.id', 'desc')->take(1)->get();
      
    if($cotizacion11[0]['empresa_id'] == null){

        $cotizacion = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.tdeentrega','anexosforaneos.area','empresas.logo','anexosforaneos.ubicacion')
            ->where('anexosforaneos.id','=',$id)->orderBy('anexosforaneos.id', 'desc')->take(1)->get();
           
    } else {
       
        $cotizacion = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
        ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
        ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
        ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
        'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
        'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
        'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.tdeentrega','anexosforaneos.area','empresas.logo','anexosforaneos.ubicacion')
        ->where('anexosforaneos.id','=',$id)->orderBy('anexosforaneos.id', 'desc')->take(1)->get();
       
    }

        $detalles = anexosFCarrito::join('AFConceptos','anexosfcarrito.pConcepto_id','=','AFConceptos.id')
        ->join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
        ->join('anexosforaneos','anexosfcarrito.presupuesto_id','=','anexosforaneos.id')
        ->select('anexosfcarrito.id','AFConceptos.descripcion','AFConceptos.num','anexosfcarrito.cantidad','anexosfcarrito.precio','anexosFCategorias.titulo','anexosFCategorias.num as nuc')
        ->where('anexosfcarrito.presupuesto_id','=',$id)
        ->orderBy('anexosfcarrito.id', 'desc')->get();

        if($cotizacion11[0]['eco_id'] == '1'){
            return \View::make('pdf.presupuesto3', compact('cotizacion', 'detalles'))->render();
            } else {
            return \View::make('pdf.presupuesto2', compact('cotizacion', 'detalles'))->render();
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
    public function pdfcfe(Request $request,$id){

        $cotizacion11 = anexosForaneos::select('anexosforaneos.empresa_id','anexosforaneos.eco_id')
            ->where('anexosforaneos.id','=',$id)->orderBy('anexosforaneos.id', 'desc')->take(1)->get();

        if($cotizacion11[0]['empresa_id'] == null){
            $cotizacion = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.tdeentrega','anexosforaneos.area','empresas.logo')
            ->where('anexosforaneos.id','=',$id)->orderBy('anexosforaneos.id', 'desc')->take(1)->get();
        } else {
            $cotizacion = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.tdeentrega','anexosforaneos.area','empresas.logo')
            ->where('anexosforaneos.id','=',$id)->orderBy('anexosforaneos.id', 'desc')->take(1)->get();
        }

        

        $detalles = anexosFCarrito::join('AFConceptos','anexosfcarrito.pConcepto_id','=','AFConceptos.id')
        ->join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
        ->join('anexosforaneos','anexosfcarrito.presupuesto_id','=','anexosforaneos.id')
        ->select('anexosfcarrito.id','AFConceptos.descripcion','AFConceptos.num','anexosfcarrito.cantidad','anexosfcarrito.precio_v as precio','anexosFCategorias.titulo','anexosFCategorias.num as nuc')
        ->where('anexosfcarrito.presupuesto_id','=',$id)
        ->orderBy('anexosfcarrito.id', 'desc')->get();

        if($cotizacion11[0]['eco_id'] == '1'){
            return \View::make('pdf.presupuesto3', compact('cotizacion', 'detalles'))->render();
            } else {
            return \View::make('pdf.presupuesto2', compact('cotizacion', 'detalles'))->render();
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

        $cotizacion11 = anexosForaneos::select('anexosforaneos.empresa_id','anexosforaneos.eco_id')
            ->where('anexosforaneos.id','=',$id)->orderBy('anexosforaneos.id', 'desc')->take(1)->get();

        if($cotizacion11[0]['empresa_id'] == null){ 
            $cotizacion = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('recepcion_vehicular','anexosFGenerales.NSolicitud','=','recepcion_vehicular.folioNum')
            ->join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.tdeentrega','empresas.logo')
            ->where('anexosforaneos.id','=',$id)->orderBy('anexosforaneos.id', 'desc')->take(1)->get();

        } else {

            $cotizacion = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.tdeentrega','empresas.logo')
            ->where('anexosforaneos.id','=',$id)->orderBy('anexosforaneos.id', 'desc')->take(1)->get();
        }

       

        $detalles = anexosFCarrito::join('AFConceptos','anexosfcarrito.pConcepto_id','=','AFConceptos.id')
        ->join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
        ->join('anexosforaneos','anexosfcarrito.presupuesto_id','=','anexosforaneos.id')
        ->select('anexosfcarrito.id','AFConceptos.descripcion','AFConceptos.num','anexosfcarrito.cantidad','anexosfcarrito.precio_v as precio','anexosFCategorias.titulo','anexosFCategorias.num as nuc')
        ->where('anexosfcarrito.presupuesto_id','=',$id)
        ->orderBy('anexosfcarrito.id', 'desc')->get();

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
 
            $cotizacion = new anexosFOE();
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

        $fotos = anexosFOE::select('archivo')
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
 
            $cotizacion = new anexosFFotosViejas();
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
 
            $cotizacion = new anexosFFotosNuevas();
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
 
            $cotizacion = new AnexosFFotosInstaladas();
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
 
            $cotizacion = new anexosFRA();
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
 
            $cotizacion = new AnexosFPDF();
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
 
            $cotizacion = new anexosFXML();
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
 
            $cotizacion = new AnexosFAcuses();
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
 
            $cotizacion = new AnexosFOS();
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

        $fotos = anexosFFotosViejas::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verReporteAnomalias(Request $request){

        $fotos = AnexosFRA::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFotosNuevas(Request $request){

        $fotos = anexosFFotosNuevas::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFotosInstaladas(Request $request){

        $fotos = AnexosFFotosInstaladas::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verAcuse(Request $request){

        $fotos = AnexosFAcuses::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verOrdenServicio(Request $request){

        $fotos = AnexosFOS::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFacturaXML(Request $request){

        $fotos = AnexosFXML::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }
    public function verFacturaPDF(Request $request){

        $fotos = AnexosFPDF::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function cambioStatus(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new anexosForaneos();
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
         
        $detalles =  anexosFCarrito::join('AFConceptos','anexosfcarrito.pConcepto_id','=','AFConceptos.id')
        ->join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
        ->select('anexosfcarrito.id','anexosfcarrito.pConcepto_id as idarticulo','AFConceptos.descripcion','AFConceptos.num','anexosfcarrito.cantidad','anexosfcarrito.precio_v as precio','anexosFCategorias.titulo','anexosFCategorias.num as nuc','anexosfcarrito.presupuesto_id')
        ->where('anexosfcarrito.presupuesto_id','=',$id)
        ->orderBy('anexosfcarrito.id', 'desc')->get();

         
        return [
           
            'detalles' => $detalles
        ];
    }

    public function desactivar(Request $request)
    {
       
     
        $cotizacion = anexosForaneos::findOrFail($request->id);
      
         $sca22 = anexosFCarrito::where('presupuesto_id','=',$request->id)->count();
         if($sca22 == 0){
         } else {
        $carro = anexosFCarrito::where('presupuesto_id','=',$request->id)->get();
        $carro33 = anexosFCarrito::findOrFail($carro[0]['id']);
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
        $categorias = anexosFCategorias::get();
        $tipos = anexosFTipos::get();
        $productos = CodigoSat::get();
        $contratos = Empresa::get();
        if ($contra == '1'){
            $cotizaciones = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.status','anexosFVehiculos.id as pVehiculos2023_id','anexosFGenerales.id as pGenerales2023_id'
            ,'anexosforaneos.descripcionMO','anexosforaneos.importe','anexosforaneos.ubicacion','anexosforaneos.tdeentrega','anexosforaneos.area')
            ->where('empresas.id','=',$buscar)->where('anexosforaneos.user_id','=',\Auth::user()->id)->orderBy('anexosforaneos.id', 'desc')->paginate(15);
            
        } else {   
        if ($buscar==''){
            $cotizaciones = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.status','anexosFVehiculos.id as pVehiculos2023_id','anexosFGenerales.id as pGenerales2023_id'
            ,'anexosforaneos.descripcionMO','anexosforaneos.importe','anexosforaneos.ubicacion','anexosforaneos.tdeentrega','anexosforaneos.area')
            ->orderBy('anexosforaneos.id', 'desc')->where('anexosforaneos.user_id','=',\Auth::user()->id)->paginate(15);
        }
        else{
            $cotizaciones = anexosForaneos::join('anexosFVehiculos','anexosforaneos.pVehiculos_id','=','anexosFVehiculos.id')
            ->join('anexosFGenerales','anexosforaneos.pGenerales_id','=','anexosFGenerales.id')
            ->join('empresas','anexosforaneos.empresa_id','=','empresas.id')
            ->select('anexosforaneos.id','anexosFGenerales.NSolicitud','anexosFGenerales.FechaAlta','anexosFGenerales.OrdenServicio',
            'anexosFGenerales.KmDeIngreso','anexosFVehiculos.identificador','anexosFVehiculos.kilometraje','anexosFVehiculos.marca',
            'anexosFVehiculos.modelo','anexosFVehiculos.ano','anexosFVehiculos.placas','anexosFVehiculos.vin','anexosFGenerales.ClienteYRazonSocial',
            'anexosFGenerales.Mail','anexosFGenerales.Telefono','anexosFGenerales.Conductor','anexosforaneos.created_at','anexosforaneos.observaciones','anexosforaneos.status','anexosFVehiculos.id as pVehiculos2023_id','anexosFGenerales.id as pGenerales2023_id'
            ,'anexosforaneos.descripcionMO','anexosforaneos.importe','anexosforaneos.ubicacion','anexosforaneos.tdeentrega','anexosforaneos.area')
            ->where($criterio, 'like', '%'. $buscar . '%')->where('anexosforaneos.user_id','=',\Auth::user()->id)->orderBy('anexosforaneos.id', 'desc')->paginate(15);
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
}
