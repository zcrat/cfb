<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\presupuestos2023;
use App\pVehiculos2023;
use App\pGenerales2023;
use App\pCategorias2023;
use App\pTipos2023;
use App\Productos;
use App\pCarrito2023;
use App\CodigoSat;
use App\OrdenEntrada2023;

use App\FotosViejas2023;
use App\FotosNuevas2023;
use App\FotosInstaladas2023;
use App\Acuse2023;
use App\OrdenServicio2023;
use App\FacturaXML2023;
use App\FacturaPDF2023;
use App\Factura;
use App\ReporteAnomalias2023;
use Response;
use App\CorrectivosOrden2023;
use App\ServicioOrden2023;
use App\TipoServicioOrden2023;
use App\Empresa;

use DB;
use Illuminate\Support\Carbon;

class presupuestos2023Controller extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $contra = $request->contra;
        $contrato = $request->contrato;
        $criterio = $request->criterio;
        $categorias = pCategorias2023::orderBy('titulo', 'asc')->get();
        $tipos = pTipos2023::orderBy('tipo', 'asc')->get();
        $productos = CodigoSat::get();
        $contratos = Empresa::orderBy('nombre','asc')->get();
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;
        $eco = $request->eco_id;
        if ($fecha_inicio=='' || $fecha_final=='' ){
        if ($contra == '1'){
            $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area','presupuestos2023.empresa_id')
            ->where('presupuestos2023.eco_id','=',$eco)->where('empresas.id','=',$buscar)->orderBy('presupuestos2023.id', 'desc')->paginate(15);
            
        } else {   
        if ($buscar==''){
            $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area','presupuestos2023.empresa_id')
            ->where('presupuestos2023.eco_id','=',$eco)->orderBy('presupuestos2023.id', 'desc')->paginate(15);
        }
        else{
            // $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            // ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            // ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            // ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            // 'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            // 'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            // 'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            // ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area')
            // ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestos2023.id', 'desc')->paginate(15);
            if($contrato == 0){
                $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
                ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
                ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
                ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
                'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
                'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
                'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
                ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area','presupuestos2023.empresa_id')
                ->where('presupuestos2023.eco_id','=',$eco)->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestos2023.id', 'desc')->paginate(15);
            } else {
                $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
                ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
                ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
                ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
                'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
                'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
                'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
                ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area','presupuestos2023.empresa_id')
                ->where('presupuestos2023.eco_id','=',$eco)->where('empresas.id', '=', $contrato)
                ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestos2023.id', 'desc')->paginate(15);
            }
        }
        }
    } else {
        $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area')
            ->where('presupuestos2023.eco_id','=',$eco)->whereBetween('presupuestos2023.created_at', [$request->fecha_inicio, $request->fecha_final])
            ->orderBy('presupuestos2023.id', 'desc')->paginate(30);
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
        $tipo = new pTipos2023();
        $tipo->tipo = $request->nombre;    
        $tipo->save();

        
        $tipos = pTipos2023::get();
        return [
            'tipos' => $tipos,
        ];
    }   

    public function categoria(Request $request)
    {
        $cate = new pCategorias2023();
        $cate->titulo = $request->nombre;    
        $cate->save();

        $categorias = pCategorias2023::get();
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


            $vehiculo = new pVehiculos2023();
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
            $generales = new pGenerales2023();
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

            
 
            
            $cotizacion = new presupuestos2023();
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
            
            $coti = new ServicioOrden2023();
            $coti->presupuesto_id = $cotizacion->id;
            $coti->preocorr_id = $request->preocorr_id;    
            $coti->ubicacion = $request->ubi;
            $coti->area = $request->area;
            $coti->save();


            if($request->preocorr_id == "2"){

                $detalles = $request->data;//Array de detalles
                foreach($detalles as $ep=>$det)
                {
                    $detalle = new CorrectivosOrden2023();
                    $detalle->presupuesto_id = $cotizacion->id;
                    $detalle->correctivo_id = $det['code'];      
                    $detalle->save();
                }     

            } 
            if($request->preocorr_id == "1"){
                $ser = new TipoServicioOrden2023();
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
        $vehiculo = new pVehiculos2023();
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
        $generales = new pGenerales2023();
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

        $cotizacion = new presupuestos2023();
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
        $categorias = pCategorias2023::select('id','num','titulo')->orderBy('titulo', 'asc')->get();
        return ['categorias' => $categorias];
    }

    public function selectCategorias(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = pTipos2023::select('id','tipo')->orderBy('tipo', 'asc')->get();
        return ['tipos' => $categorias];
    }

    public function factura(Request $request){
        if (!$request->ajax()) return redirect('/');
        $presupuesto = presupuestos2023::select('factura_id')->where('id','=',$request->id)->first();

        $factura = Factura::select('xml','pdf')
            ->where('facturas.id','=',$presupuesto->factura_id)->first();
        return [
            'xml' => $factura->xml,
            'pdf' => $factura->pdf
                ];
    }

    public function pdf(Request $request,$id){

        $cotizacion11 = presupuestos2023::select('presupuestos2023.empresa_id','presupuestos2023.eco_id')
        ->where('presupuestos2023.id','=',$id)->orderBy('presupuestos2023.id', 'desc')->take(1)->get();

    if($cotizacion11[0]['empresa_id'] == null){

        $cotizacion = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('recepcion_vehicular','pGenerales2023.NSolicitud','=','recepcion_vehicular.folioNum')
            ->join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.tdeentrega','presupuestos2023.area','empresas.logo')
            ->where('presupuestos2023.id','=',$id)->orderBy('presupuestos2023.id', 'desc')->take(1)->get();
    } else {
        $cotizacion = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
        ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
        ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
        ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
        'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
        'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
        'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.tdeentrega','presupuestos2023.area','empresas.logo')
        ->where('presupuestos2023.id','=',$id)->orderBy('presupuestos2023.id', 'desc')->take(1)->get();
    }

        $detalles = pCarrito2023::join('pConceptos2023','pCarrito2023.pConcepto_id','=','pConceptos2023.id')
        ->join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
        ->join('presupuestos2023','pCarrito2023.presupuesto_id','=','presupuestos2023.id')
        ->select('pCarrito2023.id','pConceptos2023.descripcion','pConceptos2023.num','pCarrito2023.cantidad','pCarrito2023.precio','pCategorias2023.titulo','pCategorias2023.num as nuc')
        ->where('pCarrito2023.presupuesto_id','=',$id)
        ->orderBy('pCarrito2023.id', 'desc')->get();

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

        $cotizacion11 = presupuestos2023::select('presupuestos2023.empresa_id','presupuestos2023.eco_id')
            ->where('presupuestos2023.id','=',$id)->orderBy('presupuestos2023.id', 'desc')->take(1)->get();

        if($cotizacion11[0]['empresa_id'] == null){
            $cotizacion = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('recepcion_vehicular','pGenerales2023.NSolicitud','=','recepcion_vehicular.folioNum')
            ->join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.tdeentrega','presupuestos2023.area','empresas.logo')
            ->where('presupuestos2023.id','=',$id)->orderBy('presupuestos2023.id', 'desc')->take(1)->get();
        } else {
            $cotizacion = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.tdeentrega','presupuestos2023.area','empresas.logo')
            ->where('presupuestos2023.id','=',$id)->orderBy('presupuestos2023.id', 'desc')->take(1)->get();
        }

        

        $detalles = pCarrito2023::join('pConceptos2023','pCarrito2023.pConcepto_id','=','pConceptos2023.id')
        ->join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
        ->join('presupuestos2023','pCarrito2023.presupuesto_id','=','presupuestos2023.id')
        ->select('pCarrito2023.id','pConceptos2023.descripcion','pConceptos2023.num','pCarrito2023.cantidad','pCarrito2023.precio_v as precio','pCategorias2023.titulo','pCategorias2023.num as nuc')
        ->where('pCarrito2023.presupuesto_id','=',$id)
        ->orderBy('pCarrito2023.id', 'desc')->get();

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

        $cotizacion11 = presupuestos2023::select('presupuestos2023.empresa_id')
            ->where('presupuestos2023.id','=',$id)->orderBy('presupuestos2023.id', 'desc')->take(1)->get();

        if($cotizacion11[0]['empresa_id'] == null){ 
            $cotizacion = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('recepcion_vehicular','pGenerales2023.NSolicitud','=','recepcion_vehicular.folioNum')
            ->join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.tdeentrega','presupuestos2023.area','empresas.logo')
            ->where('presupuestos2023.id','=',$id)->orderBy('presupuestos2023.id', 'desc')->take(1)->get();

        } else {

            $cotizacion = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.tdeentrega','presupuestos2023.area','empresas.logo')
            ->where('presupuestos2023.id','=',$id)->orderBy('presupuestos2023.id', 'desc')->take(1)->get();
        }

       

        $detalles = pCarrito2023::join('pConceptos2023','pCarrito2023.pConcepto_id','=','pConceptos2023.id')
        ->join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
        ->join('presupuestos2023','pCarrito2023.presupuesto_id','=','presupuestos2023.id')
        ->select('pCarrito2023.id','pConceptos2023.descripcion','pConceptos2023.num','pCarrito2023.cantidad','pCarrito2023.precio_v as precio','pCategorias2023.titulo','pCategorias2023.num as nuc')
        ->where('pCarrito2023.presupuesto_id','=',$id)
        ->orderBy('pCarrito2023.id', 'desc')->get();

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
 
            $cotizacion = new OrdenEntrada2023();
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

        $fotos = OrdenEntrada2023::select('archivo')
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
 
            $cotizacion = new FotosViejas2023();
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
 
            $cotizacion = new FotosNuevas2023();
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
 
            $cotizacion = new FotosInstaladas2023();
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
 
            $cotizacion = new ReporteAnomalias2023();
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
 
            $cotizacion = new FacturaPDF2023();
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
 
            $cotizacion = new FacturaXML2023();
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
 
            $cotizacion = new Acuse2023();
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
 
            $cotizacion = new OrdenServicio2023();
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

        $fotos = FotosViejas2023::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verReporteAnomalias(Request $request){

        $fotos = ReporteAnomalias2023::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFotosNuevas(Request $request){

        $fotos = FotosNuevas2023::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFotosInstaladas(Request $request){

        $fotos = FotosInstaladas2023::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verAcuse(Request $request){

        $fotos = Acuse2023::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verOrdenServicio(Request $request){

        $fotos = OrdenServicio2023::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function verFacturaXML(Request $request){

        $fotos = FacturaXML2023::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }
    public function verFacturaPDF(Request $request){

        $fotos = FacturaPDF2023::select('archivo')
            ->where('presupuesto_id','=',$request->id)->get();
      
        
        return $fotos[0]['archivo'];
    }

    public function cambioStatus(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new presupuestos2023();
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
         
        $detalles =  pCarrito2023::join('pConceptos2023','pCarrito2023.pConcepto_id','=','pConceptos2023.id')
        ->join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
        ->join('presupuestos2023','pCarrito2023.presupuesto_id','=','presupuestos2023.id')
        ->select('pCarrito2023.id','pCarrito2023.pConcepto_id as idarticulo','pConceptos2023.descripcion','pConceptos2023.num','pCarrito2023.cantidad','pCarrito2023.precio_v as precio','pCategorias2023.titulo','pCategorias2023.num as nuc','pCarrito2023.presupuesto_id')
        ->where('pCarrito2023.presupuesto_id','=',$id)
        ->orderBy('pCarrito2023.id', 'desc')->get();

         
        return [
           
            'detalles' => $detalles
        ];
    }

    public function desactivar(Request $request)
    {
       
     
        $cotizacion = presupuestos2023::findOrFail($request->id);
       

        $so22 = ServicioOrden2023::where('presupuesto_id','=',$request->id)->count();
        if($so22 == 0){
           
        } else {
        $so = ServicioOrden2023::select('id','preocorr_id')->where('presupuesto_id','=',$request->id)->get();
        $so1 = ServicioOrden2023::findOrFail($so[0]['id']);
        $estado0= $so1->delete();
     
        if($so[0]['preocorr_id'] == "2"){
        $co = CorrectivosOrden2023::select('id')->where('presupuesto_id','=',$request->id)->get();
        $co1 = CorrectivosOrden2023::findOrFail($co[0]['id']);
        $estado1= $co1->delete();
        }
        if($so[0]['preocorr_id'] == "1"){
        $ts = TipoServicioOrden2023::select('id')->where('presupuesto_id','=',$request->id)->get();
        $ts1 = TipoServicioOrden2023::findOrFail($ts[0]['id']);
        $estado2= $ts1->delete();
        }

         }
         $sca22 = pCarrito2023::where('presupuesto_id','=',$request->id)->count();
         if($sca22 == 0){
         } else {
        $carro = pCarrito2023::where('presupuesto_id','=',$request->id)->get();
        $carro33 = pCarrito2023::findOrFail($carro[0]['id']);
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
        $categorias = pCategorias2023::orderBy('titulo', 'asc')->get();
        $tipos = pTipos2023::orderBy('tipo', 'asc')->get();
        $productos = CodigoSat::get();
        $contratos = Empresa::get();
        if ($contra == '1'){
            $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area')
            ->where('empresas.id','=',$buscar)->where('presupuestos2023.user_id','=',\Auth::user()->id)->orderBy('presupuestos2023.id', 'desc')->paginate(15);
            
        } else {   
        if ($buscar==''){
            $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area')
            ->orderBy('presupuestos2023.id', 'desc')->where('presupuestos2023.user_id','=',\Auth::user()->id)->paginate(15);
        }
        else{
            $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area')
            ->where($criterio, 'like', '%'. $buscar . '%')->where('presupuestos2023.user_id','=',\Auth::user()->id)->orderBy('presupuestos2023.id', 'desc')->paginate(15);
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
        $contrato = $request->contrato;
        $criterio = $request->criterio;
        $categorias = pCategorias2023::orderBy('titulo', 'asc')->get();
        $tipos = pTipos2023::orderBy('tipo', 'asc')->get();
        $productos = CodigoSat::get();
        $contratos = Empresa::orderBy('nombre','asc')->get();
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final = $request->fecha_final;
        if ($fecha_inicio=='' || $fecha_final=='' ){
        if ($contra == '1'){
            $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area','presupuestos2023.empresa_id')
            ->where('empresas.id','=',$buscar)->orderBy('presupuestos2023.id', 'desc')->paginate(10000);
            
        } else {   
        if ($buscar==''){
            $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area','presupuestos2023.empresa_id')
            ->orderBy('presupuestos2023.id', 'desc')->paginate(15);
        }
        else{
            // $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            // ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            // ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            // ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            // 'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            // 'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            // 'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            // ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area')
            // ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestos2023.id', 'desc')->paginate(15);
            if($contrato == 0){
                $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
                ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
                ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
                ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
                'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
                'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
                'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
                ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area','presupuestos2023.empresa_id')
                ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestos2023.id', 'desc')->paginate(10000);
            } else {
                $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
                ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
                ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
                ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
                'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
                'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
                'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
                ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area','presupuestos2023.empresa_id')
                ->where('empresas.id', '=', $contrato)
                ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('presupuestos2023.id', 'desc')->paginate(10000);
            }
        }
        }
    } else {
        $cotizaciones = presupuestos2023::join('pVehiculos2023','presupuestos2023.pVehiculos_id','=','pVehiculos2023.id')
            ->join('pGenerales2023','presupuestos2023.pGenerales_id','=','pGenerales2023.id')
            ->join('empresas','presupuestos2023.empresa_id','=','empresas.id')
            ->select('presupuestos2023.id','pGenerales2023.NSolicitud','pGenerales2023.FechaAlta','pGenerales2023.OrdenServicio',
            'pGenerales2023.KmDeIngreso','pVehiculos2023.identificador','pVehiculos2023.kilometraje','pVehiculos2023.marca',
            'pVehiculos2023.modelo','pVehiculos2023.ano','pVehiculos2023.placas','pVehiculos2023.vin','pGenerales2023.ClienteYRazonSocial',
            'pGenerales2023.Mail','pGenerales2023.Telefono','pGenerales2023.Conductor','presupuestos2023.created_at','presupuestos2023.observaciones','presupuestos2023.status','pVehiculos2023.id as pVehiculos2023_id','pGenerales2023.id as pGenerales2023_id'
            ,'presupuestos2023.descripcionMO','presupuestos2023.importe','presupuestos2023.ubicacion','presupuestos2023.tdeentrega','presupuestos2023.area')
            ->whereBetween('presupuestos2023.created_at', [$request->fecha_inicio, $request->fecha_final])
            ->orderBy('presupuestos2023.id', 'desc')->paginate(10000);
    }

    
         
    return \View::make('pdf.exelExport')->with('detalles',$cotizaciones);
    }
}
