<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Cotizaciones;
use App\DetalleCotizacion;

use App\User;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use App\Notifications\NotifyAdmin;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class CotizacionesController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $cotizaciones = Cotizaciones::join('empresas','cotizaciones.empresa_id','=','empresas.id')
            ->select('cotizaciones.id','cotizaciones.odes','cotizaciones.id_text','cotizaciones.placas',
            'cotizaciones.vim','cotizaciones.n_economico','cotizaciones.fecha','cotizaciones.estado')
            ->orderBy('cotizaciones.id', 'desc')->paginate(10);
        }
        else{
            $cotizaciones = Cotizaciones::join('empresas','cotizaciones.empresa_id','=','empresas.id')
            ->select('cotizaciones.id','cotizaciones.odes','cotizaciones.id_text','cotizaciones.placas',
            'cotizaciones.vim','cotizaciones.n_economico','cotizaciones.fecha','cotizaciones.estado')
            ->where('cotizaciones.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('cotizaciones.id', 'desc')->paginate(10);
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

    public function pdf(Request $request,$id){
        $cotizacion = Cotizaciones::join('empresas','cotizaciones.empresa_id','=','empresas.id')
        ->select('cotizaciones.id','cotizaciones.vehiculo','cotizaciones.odes','cotizaciones.id_text',
        'cotizaciones.ejecutivo','cotizaciones.placas','cotizaciones.vim','cotizaciones.n_economico',
        'cotizaciones.km_odometro','cotizaciones.tiempo_entrega','cotizaciones.observaciones',
        'cotizaciones.fecha','cotizaciones.impuesto','cotizaciones.total','cotizaciones.estado',
        'empresas.logo')
        ->where('cotizaciones.id','=',$id)
        ->orderBy('cotizaciones.id','desc')->take(1)->get();

        $detalles = DetalleCotizacion::join('articulos','detalle_cotizacion.idarticulo','=','articulos.id')
        ->select('articulos.idcategoria','articulos.codigo_sat','detalle_cotizacion.cantidad','detalle_cotizacion.precio',
        'articulos.descripcion as articulo')
        ->where('detalle_cotizacion.cotizacion_id','=',$id)
        ->orderBy('detalle_cotizacion.id','desc')->get();

        $numventa=Cotizaciones::select('id')->where('id',$id)->get();

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
 
            
            $cotizacion = new Cotizaciones();
            $cotizacion->empresa_id = $request->idempresa;
            $cotizacion->vehiculo = $request->vehiculo;
            $cotizacion->idusuario = \Auth::user()->id;
            $cotizacion->odes = $request->odes;
            $cotizacion->id_text = $request->id_text;
            $cotizacion->ejecutivo = $request->ejecutivo;
            $cotizacion->placas = $request->placas;
            $cotizacion->vim = $request->vim;
            $cotizacion->n_economico = $request->n_economico;
            $cotizacion->km_odometro =$request->km_odometro;
            $cotizacion->tiempo_entrega =$request->tiempo_entrega;;
            $cotizacion->observaciones =$request->observaciones;
            $cotizacion->fecha = $request->fecha;
            $cotizacion->impuesto = $request->impuesto;
            $cotizacion->total = $request->total;
            $cotizacion->estado = 'Registrado';
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
            $fechaActual= date('Y-m-d');
            $numVentas = DB::table('ventas')->whereDate('created_at', $fechaActual)->count();
            $numIngresos = DB::table('ingresos')->whereDate('created_at', $fechaActual)->count();

           

            $arregloDatos = [
                'ventas' => [
                            'numero' => $numVentas,
                            'msj' => 'Ventas'
                        ],
                'ingresos' => [
                            'numero' => $numIngresos,
                            'msj' => 'Ingresos'
                ]
            ];
            $allUsers = User::all();
       

            foreach ($allUsers as $notificar){
                User::findOrFail($notificar->id)->notify(new NotifyAdmin($arregloDatos));
            }
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
 
    public function desactivar(Request $request)
    {
       
        $cotizacion = Cotizaciones::findOrFail($request->id);
       
        //Eliminamos los clientes de esa empresa
        $cotizacion->detalles()->delete();
        return $cotizacion;;
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }

   
}
