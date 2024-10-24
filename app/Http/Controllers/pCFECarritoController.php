<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pCFECarrito;
use App\User;
use DB;

class pCFECarritoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        
            $cotizaciones = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
            ->join('presupuestosCFE','pCFECarrito.presupuestoCFE_id','=','presupuestosCFE.id')
            ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v')
            ->where('pCFECarrito.presupuestoCFE_id','=',$id)
            ->orderBy('pCFECarrito.id', 'desc')->get();
         
        return [
            'detalleconceptos' => $cotizaciones,
        ];
    }

    public function store(Request $request)
    {

       
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
          
            $vehiculo = new pCFECarrito();
            $vehiculo->presupuestoCFE_id = $request->presupuestoCFE_id;
            $vehiculo->pCFEConcepto_id = $request->pCFEConcepto_id;
            $vehiculo->cantidad = $request->cantidad;
            $vehiculo->precio = $request->precio_nuevo;
            $vehiculo->precio_v = $request->precio;
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

 
            $sucursal = pCFECarrito::findOrFail($request->id);
            $sucursal->delete();
    
            $estado = true;
            return collect(['estado' => $estado]);
        
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = pCFECarrito::findOrFail($request->id);
        $articulo->cantidad = $request->cantidad;
        $articulo->precio = $request->precio;
        $articulo->precio_v = $request->precio_v;
        $articulo->save();
    }
}
