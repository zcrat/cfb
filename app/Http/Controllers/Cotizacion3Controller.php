<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Cotizacion3;
use App\DetalleCotizacion;

use App\User;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use App\Notifications\NotifyAdmin;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class Cotizacion3Controller extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $cotizaciones = Cotizacion3::select('id','strodes','strid','strejecutivo','strubicacion','iduser','idautorizo','strfirma','idreporterv','fecha','tentrega','observa','idcompra','vehiculo','placas','vin','kmo','economico','idcliente','status','tecnico_id','niveles')
            ->orderBy('id', 'desc')->paginate(10);
        }
        else{
            $cotizaciones = Cotizacion3::select('id','strodes','strid','strejecutivo','strubicacion','iduser','idautorizo','strfirma','idreporterv','fecha','tentrega','observa','idcompra','vehiculo','placas','vin','kmo','economico','idcliente','status','tecnico_id','niveles')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
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
            'cotizaciones' => $cotizaciones
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
         

        $cotizacion = Cotizaciones::join('empresas','cotizaciones.empresa_id','=','empresas.id')
        ->select('cotizaciones.id','empresas.nombre','vehiculos.no_economico',
        'vehiculos.vim','cotizaciones.odes','cotizaciones.id_text',
        'vehiculos.created_at')
        ->where('cotizaciones.id','=',$id)
        ->orderBy('cotizaciones.id', 'desc')->take(1)->get();

         
        return [
           
            'cotizacion' => $cotizacion
        ];
    }
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
         
        $detalles = DetalleCotizacion::join('articulos','detalle_cotizacion.idarticulo','=','articulos.id')
        ->select('detalle_cotizacion.idarticulo','detalle_cotizacion.cantidad','detalle_cotizacion.precio'
        ,'articulos.descripcion')
        ->where('detalle_cotizacion.cotizacion_id','=',$id)
        ->orderBy('detalle_cotizacion.id', 'desc')->get();

         
        return [
           
            'detalles' => $detalles
        ];
    }

    public function selectDetalle(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;

    
         
        $detalles = DetalleCotizacion::join('productos','cotizacion3_detalle_cotizacion.idarticulo','=','productos.id')
        ->select('cotizacion3_detalle_cotizacion.id','cotizacion3_detalle_cotizacion.idarticulo','cotizacion3_detalle_cotizacion.cantidad','cotizacion3_detalle_cotizacion.precio'
        ,'productos.strdescripcion as descripcion')
        ->where('cotizacion3_detalle_cotizacion.cotizacion3_id','=',$id)
        ->orderBy('cotizacion3_detalle_cotizacion.id', 'desc')->get();

         
        return [
           
            'detalles' => $detalles
        ];
    }

    public function deleteDetalle(Request $request){
        
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $cotizacion = DetalleCotizacion::findOrFail($request->id);
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
       
    }

    public function pdf(Request $request,$id){
        $cotizacion = Cotizacion3::join('empresas','cotizacion3.idcliente','=','empresas.id')
        ->select('cotizacion3.id','cotizacion3.vehiculo','cotizacion3.strodes','cotizacion3.strid',
        'cotizacion3.strejecutivo','cotizacion3.placas','cotizacion3.vin','cotizacion3.economico',
        'cotizacion3.kmo','cotizacion3.tentrega','cotizacion3.observa',
        'cotizacion3.fecha','empresas.logo')
        ->where('cotizacion3.id','=',$id)
        ->orderBy('cotizacion3.id','desc')->take(1)->get();

        $detalles = DetalleCotizacion::join('productos','cotizacion3_detalle_cotizacion.idarticulo','=','productos.id')
        ->select('productos.idcategoria','productos.codigosat','cotizacion3_detalle_cotizacion.cantidad','cotizacion3_detalle_cotizacion.precio',
        'productos.strdescripcion as articulo')
        ->where('cotizacion3_detalle_cotizacion.cotizacion3_id','=',$id)
        ->orderBy('cotizacion3_detalle_cotizacion.id','desc')->get();

        $numventa=Cotizacion3::select('id')->where('id',$id)->get();

        return \View::make('pdf.prueba', compact('cotizacion', 'detalles'))->render();
       // if ($m == 1){
       // $pdf = \PDF::loadView('pdf.cotizacion',['cotizacion'=>$cotizacion,'detalles'=>$detalles]);
       // return $pdf->download('cotizacion-'.$numventa[0]->id.'.pdf');
       // } else if ($m == 2) {
      //  $view =  \View::make('pdf.cotizacion', compact('cotizacion', 'detalles'))->render();
      //  $pdf = \App::make('dompdf.wrapper');
      //  $pdf->loadHTML($view);
      //  return $pdf->stream('cotizacion');}

      

    }
    public function store(Request $request)
    {
            
  
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
 
            $fechita = Carbon::parse($request->fecha)->format('Y-m-d H:m');
            $cotizacion = new Cotizacion3();
            $cotizacion->strodes = $request->odes;
            $cotizacion->strid = $request->id_text;
            $cotizacion->strejecutivo = $request->ejecutivo;
            $cotizacion->strubicacion = $request->ubicacion;
            $cotizacion->iduser = \Auth::user()->id;
            $cotizacion->fecha = $fechita;
            $cotizacion->tentrega =$request->tiempo_entrega;
            $cotizacion->observa =$request->observaciones;
            $cotizacion->vehiculo = $request->vehiculo;
            $cotizacion->placas = $request->placas;
            $cotizacion->vin = $request->vim;
            $cotizacion->kmo =$request->km_odometro;
            $cotizacion->economico = $request->n_economico;
            $cotizacion->idcliente = $request->idempresa;
            $cotizacion->save();               
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
       
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleCotizacion();
                $detalle->cotizacion_id = $cotizacion->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
                $detalle->save();
                
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
 
        $mytime= Carbon::now('America/Lima');
 
        $fechita = Carbon::parse($request->fecha)->format('Y-m-d H:m');
        $cotizacion = Cotizacion3::findOrFail($request->id);
        $cotizacion->strodes = $request->odes;
        $cotizacion->strid = $request->id_text;
        $cotizacion->strejecutivo = $request->ejecutivo;
        $cotizacion->strubicacion = $request->ubicacion;
        $cotizacion->fecha = $fechita;
        $cotizacion->tentrega =$request->tiempo_entrega;
        $cotizacion->observa =$request->observaciones;
        $cotizacion->vehiculo = $request->vehiculo;
        $cotizacion->placas = $request->placas;
        $cotizacion->vin = $request->vim;
        $cotizacion->kmo =$request->km_odometro;
        $cotizacion->economico = $request->n_economico;
        $cotizacion->idcliente = $request->idempresa;
        $cotizacion->save();    
        
        $detalles = $request->data;//Array de detalles
        //Recorro todos los elementos    
        $cotizacion->detalle()->sync($request->data);
             
       
        return [
            'id'=> $cotizacion->id
        ];
    }
 
    public function desactivar(Request $request)
    {
       
        $cotizacion = Cotizacion3::findOrFail($request->id);
       
        //Eliminamos los clientes de esa empresa
        $cotizacion->detalles()->delete();
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }

   
}
