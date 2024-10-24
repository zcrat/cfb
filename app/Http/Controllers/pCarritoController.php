<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pCarrito;
use App\User;
use DB;

class pCarritoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        
            $cotizaciones = pCarrito::join('pConceptos','pCarrito.pConcepto_id','=','pConceptos.id')
            ->join('presupuestos','pCarrito.presupuesto_id','=','presupuestos.id')
            ->select('pCarrito.id','pConceptos.descripcion','pCarrito.cantidad','pCarrito.precio','pCarrito.precio_v')
            ->where('pCarrito.presupuesto_id','=',$id)
            ->orderBy('pCarrito.id', 'desc')->get();
         
        return [
            'detalleconceptos' => $cotizaciones,
        ];
    }

    public function store(Request $request)
    {

       
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
            $preciov = $request->precio_nuevo*1.82;
            $vehiculo = new pCarrito();
            $vehiculo->presupuesto_id = $request->presupuestoCFE_id;
            $vehiculo->pConcepto_id = $request->pCFEConcepto_id;
            $vehiculo->cantidad = $request->cantidad;
            $vehiculo->precio = $request->precio_nuevo;
            $vehiculo->precio_v = $preciov;
            $vehiculo->usuario_id = \Auth::user()->id;
            $vehiculo->save();

            DB::commit();
            return [
                'id'=> $vehiculo->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function delete(Request $request){

 
            $sucursal = pCarrito::findOrFail($request->id);
            $sucursal->delete();
    
            $estado = true;
            return collect(['estado' => $estado]);
        
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = pCarrito::findOrFail($request->id);
        $articulo->cantidad = $request->cantidad;
        $articulo->precio = $request->precio;
        $articulo->precio_v = $request->precio_v;
        $articulo->save();
    }
}
