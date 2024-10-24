<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CajaBancos;
use DB;
use App\FacturasCajaBancos;
use App\Cuentas;
use App\Caja;
use App\FacturasCaja;

class SaldosController extends Controller
{
    public function index(Request $request)
    {

        if($request->idcuenta==0){
            if (!$request->ajax()) return redirect('/');

            $finicio = $request->finicio;
            $ffinal = $request->ffinal;
            $cuentas = Cuentas::get();
    
            
            $cajacount = CajaBancos::count();
           
            if($cajacount == 0){
                $saldo = '0';  
            } else {   
                $caja = CajaBancos::select('caja_bancos.id','caja_bancos.fecha','caja_bancos.concepto','caja_bancos.ingreso','caja_bancos.egreso','caja_bancos.saldo')
                ->orderBy('id', 'desc')->get();
            $saldo = $caja[0]['saldo'];  
    
           
    
            }
    
            $cajacount1 = Caja::count();
       
            if($cajacount1 == 0){
                $saldo1 = '0';  
            } else {   
                $caja1 = Caja::select('caja.id','caja.fecha','caja.concepto','caja.ingreso','caja.egreso','caja.saldo')
                ->orderBy('id', 'desc')->get();
            $saldo1 = $caja1[0]['saldo'];  
    
            
    
            }
    
       
            
            if ($finicio==''){
    
                $categorias = CajaBancos::join('cuentas','caja_bancos.cuenta_id','=','cuentas.id')
                ->join('bancos','cuentas.bancos_id','=','bancos.id')
                ->join('monedas','cuentas.monedas_id','=','monedas.id')
                ->select('caja_bancos.cuenta_id','cuentas.id','bancos.nombre as banco','cuentas.noCuenta as cuenta','monedas.nombre as moneda',DB::raw('MAX(egreso) as egreso'),DB::raw('MAX(ingreso) as ingreso'),DB::raw('MAX(fecha) as updated_at'))
                ->orderBy('caja_bancos.cuenta_id', 'desc')
                ->groupBy('caja_bancos.cuenta_id')
                ->paginate(1000);  
                // $categorias = Cuentas::join('bancos','cuentas.bancos_id','=','bancos.id')
                // ->join('caja_bancos','cuentas.id','=','caja_bancos.cuenta_id')
                // ->join('monedas','cuentas.monedas_id','=','monedas.id')
                // ->select('cuentas.id','bancos.nombre as banco','cuentas.noCuenta as cuenta','monedas.nombre as moneda')
                // ->orderBy('cuentas.id', 'desc')
                // ->groupBy('cuentas.id')
                // ->paginate(50);  
            }
            else{
    
                $categorias = CajaBancos::join('cuentas','caja_bancos.cuenta_id','=','cuentas.id')
                ->join('bancos','cuentas.bancos_id','=','bancos.id')
                ->join('monedas','cuentas.monedas_id','=','monedas.id')
                ->select('caja_bancos.cuenta_id','cuentas.id','bancos.nombre as banco','cuentas.noCuenta as cuenta','monedas.nombre as moneda',DB::raw('MAX(egreso) as egreso'),DB::raw('MAX(ingreso) as ingreso'),DB::raw('MAX(fecha) as updated_at'))
                ->whereBetween('caja_bancos.fecha', [$finicio, $ffinal])
                ->orderBy('caja_bancos.cuenta_id', 'desc')
                ->groupBy('caja_bancos.cuenta_id')
                ->paginate(1000);  
            }
            
    
            return [
                'pagination' => [
                    'total'        => $categorias->total(),
                    'current_page' => $categorias->currentPage(),
                    'per_page'     => $categorias->perPage(),
                    'last_page'    => $categorias->lastPage(),
                    'from'         => $categorias->firstItem(),
                    'to'           => $categorias->lastItem(),
                ],
                'bancos' => $categorias,
                'saldo' => $saldo1,
                'saldobanco' => $saldo,
            ];
        } else {
            if (!$request->ajax()) return redirect('/');

            $finicio = $request->finicio;
            $ffinal = $request->ffinal;
            $cuentas = Cuentas::get();
    
            
            $cajacount = CajaBancos::count();
           
            if($cajacount == 0){
                $saldo = '0';  
            } else {   
                $caja = CajaBancos::select('caja_bancos.id','caja_bancos.fecha','caja_bancos.concepto','caja_bancos.ingreso','caja_bancos.egreso','caja_bancos.saldo')
                ->where('caja_bancos.cuenta_id','=',$request->idcuenta)
                ->orderBy('id', 'desc')->get();
            $saldo = $caja[0]['saldo'];  
    
           
    
            }
    
            $cajacount1 = Caja::count();
       
            if($cajacount1 == 0){
                $saldo1 = '0';  
            } else {   
                $caja1 = Caja::select('caja.id','caja.fecha','caja.concepto','caja.ingreso','caja.egreso','caja.saldo')
                ->orderBy('id', 'desc')->get();
            $saldo1 = $caja1[0]['saldo'];  
    
            
    
            }
    
       
            
            if ($finicio==''){
    
                $categorias = CajaBancos::join('cuentas','caja_bancos.cuenta_id','=','cuentas.id')
                ->join('bancos','cuentas.bancos_id','=','bancos.id')
                ->join('monedas','cuentas.monedas_id','=','monedas.id')
                ->select('caja_bancos.cuenta_id','cuentas.id','bancos.nombre as banco','cuentas.noCuenta as cuenta','monedas.nombre as moneda', 'caja_bancos.egreso' , 'caja_bancos.ingreso' , 'caja_bancos.saldo' , 'caja_bancos.fecha as updated_at')
                ->where('caja_bancos.cuenta_id','=',$request->idcuenta)
                ->orderBy('caja_bancos.id', 'asc')
                ->paginate(1000);  
                // $categorias = Cuentas::join('bancos','cuentas.bancos_id','=','bancos.id')
                // ->join('caja_bancos','cuentas.id','=','caja_bancos.cuenta_id')
                // ->join('monedas','cuentas.monedas_id','=','monedas.id')
                // ->select('cuentas.id','bancos.nombre as banco','cuentas.noCuenta as cuenta','monedas.nombre as moneda')
                // ->orderBy('cuentas.id', 'desc')
                // ->groupBy('cuentas.id')
                // ->paginate(50);  
            }
            else{

                $categorias = CajaBancos::join('cuentas','caja_bancos.cuenta_id','=','cuentas.id')
                ->join('bancos','cuentas.bancos_id','=','bancos.id')
                ->join('monedas','cuentas.monedas_id','=','monedas.id')
                ->select('caja_bancos.cuenta_id','cuentas.id','bancos.nombre as banco','cuentas.noCuenta as cuenta','monedas.nombre as moneda', 'caja_bancos.egreso' , 'caja_bancos.ingreso' , 'caja_bancos.saldo' , 'caja_bancos.fecha as updated_at')
                ->where('caja_bancos.cuenta_id','=',$request->idcuenta)
                ->whereBetween('caja_bancos.fecha', [$finicio, $ffinal])
                ->orderBy('caja_bancos.id', 'asc')
                ->paginate(1000);  
    
            
            }
            
    
            return [
                'pagination' => [
                    'total'        => $categorias->total(),
                    'current_page' => $categorias->currentPage(),
                    'per_page'     => $categorias->perPage(),
                    'last_page'    => $categorias->lastPage(),
                    'from'         => $categorias->firstItem(),
                    'to'           => $categorias->lastItem(),
                ],
                'bancos' => $categorias,
                'saldo' => $saldo1,
                'saldobanco' => $saldo,
            ];

        }
       
        
        
    }


    
}
