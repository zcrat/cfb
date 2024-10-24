<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\OrdenesForaneas;
use Illuminate\Support\Carbon;

class OrdenesForaneasController extends Controller
{
    public function index(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $from = Carbon::parse($request->from)->format('Y-m-d');
        $to = Carbon::parse($request->to)->format('Y-m-d');


        $sinnada  = OrdenesForaneas::select('total')
        ->where('status','=','0')
        ->orderBy('id', 'DESC')->get();

        $sinnadaconfa  = OrdenesForaneas::select('total')
        ->where('status','=','1')
        ->orderBy('id', 'DESC')->get();

        $conalgo  = OrdenesForaneas::select('total')
        ->where('status','=','2')
        ->orderBy('id', 'DESC')->get();


        $sinpanifa = 0;
        $sinpaconfa = 0;
        $conpayfa = 0;
        foreach($sinnada as $compra){
        $sinpanifa = $compra->total + $sinpanifa;
        }

        foreach($sinnadaconfa as $compra){    
        $sinpaconfa = $compra->total + $sinpaconfa;
        }


       foreach($conalgo as $compra){
        $conpayfa = $compra->total + $conpayfa;
        }    
   
       

       
        
        
        if ($buscar==''){

            if($request->from == ''){
                $ordenesforaneas = OrdenesForaneas::orderBy('id', 'desc')->paginate(20);
                } else {
                $ordenesforaneas = OrdenesForaneas::whereBetween('fecha', [$from, $to])->orderBy('id', 'desc')->paginate(20);
                }
            
        }
        else{
            $ordenesforaneas = OrdenesForaneas::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);  
        }
        
        return [
            'pagination' => [
                'total'        => $ordenesforaneas->total(),
                'current_page' => $ordenesforaneas->currentPage(),
                'per_page'     => $ordenesforaneas->perPage(),
                'last_page'    => $ordenesforaneas->lastPage(),
                'from'         => $ordenesforaneas->firstItem(),
                'to'           => $ordenesforaneas->lastItem(),
            ],
            'ordenesforaneas' => $ordenesforaneas,
            'sinpanifa' => $sinpanifa, 
            'sinpaconfa' => $sinpaconfa, 
            'confaypa' => $conpayfa  
        ];
    }

    public function store(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $ordenpago = new OrdenesForaneas();
            $ordenpago->fecha = $request->fecha;
            $ordenpago->orden = $request->orden;
            $ordenpago->empresa = $request->empresa;
            $ordenpago->placa = $request->placa;
            $ordenpago->serie = $request->serie;
            $ordenpago->os =  $request->os;    
            $ordenpago->folio_sistema = $request->folio_sistema; 
            $ordenpago->presupuesto = $request->presupuesto; 
            $ordenpago->factura = $request->factura; 
            $ordenpago->monto = $request->monto; 
            $ordenpago->iva = $request->iva;    
            $ordenpago->total = $request->total; 
            $ordenpago->status = $request->status; 
            $ordenpago->save();
         


            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $ordenpago = OrdenesForaneas::findOrFail($request->id);
            $ordenpago->fecha = $request->fecha;
            $ordenpago->orden = $request->orden;
            $ordenpago->empresa = $request->empresa;
            $ordenpago->placa = $request->placa;
            $ordenpago->serie = $request->serie;
            $ordenpago->os =  $request->os;    
            $ordenpago->folio_sistema = $request->folio_sistema; 
            $ordenpago->presupuesto = $request->presupuesto; 
            $ordenpago->factura = $request->factura; 
            $ordenpago->monto = $request->monto; 
            $ordenpago->iva = $request->iva;    
            $ordenpago->total = $request->total; 
            $ordenpago->status = $request->status;    
            $ordenpago->save();

        
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function delete(Request $request){

 
        $sucursal = OrdenesForaneas::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
}
