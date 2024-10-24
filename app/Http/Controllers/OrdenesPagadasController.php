<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\OrdenesPagadas;
use Illuminate\Support\Carbon;

class OrdenesPagadasController extends Controller
{
    public function index(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $from = Carbon::parse($request->from)->format('Y-m-d');
        $to = Carbon::parse($request->to)->format('Y-m-d');

        $sinnada  = OrdenesPagadas::select('total')
        ->where('status','=','0')
        ->orderBy('id', 'DESC')->get();

        $sinnadaconfa  = OrdenesPagadas::select('total')
        ->where('status','=','1')
        ->orderBy('id', 'DESC')->get();

        $conalgo  = OrdenesPagadas::select('total')
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
                $ordenespagos = OrdenesPagadas::orderBy('id', 'desc')->paginate(20);
                } else {
                $ordenespagos = OrdenesPagadas::whereBetween('fecha', [$from, $to])->orderBy('id', 'desc')->paginate(20);
                }
            
        }
        else{
            $ordenespagos = OrdenesPagadas::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);  
        }
        
        return [
            'pagination' => [
                'total'        => $ordenespagos->total(),
                'current_page' => $ordenespagos->currentPage(),
                'per_page'     => $ordenespagos->perPage(),
                'last_page'    => $ordenespagos->lastPage(),
                'from'         => $ordenespagos->firstItem(),
                'to'           => $ordenespagos->lastItem(),
            ],
            'ordenespagos' => $ordenespagos, 
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

            $ordenpago = new OrdenesPagadas();
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

            $ordenpago = OrdenesPagadas::findOrFail($request->id);
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

 
        $sucursal = OrdenesPagadas::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
}
