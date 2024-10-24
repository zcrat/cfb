<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pCarrito2023;
use App\User;
use Illuminate\Support\Carbon;
use DB;

class pCarrito2023Controller extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        
            $cotizaciones = pCarrito2023::join('pConceptos2023','pCarrito2023.pConcepto_id','=','pConceptos2023.id')
            ->join('presupuestos2023','pCarrito2023.presupuesto_id','=','presupuestos2023.id')
            ->select('pCarrito2023.id','pConceptos2023.descripcion','pCarrito2023.cantidad','pCarrito2023.precio','pCarrito2023.precio_v')
            ->where('pCarrito2023.presupuesto_id','=',$id)
            ->orderBy('pCarrito2023.id', 'desc')->get();
         
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
            $vehiculo = new pCarrito2023();
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
    public function store2(Request $request)
    {

       
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
            $prueba= Carbon::now('America/Lima');
            $fecha123 = Carbon::parse($request->fecha_aplicacion)->format('Y-m-d H:m');
            $vehiculo = new pCarrito2023();
            $vehiculo->presupuesto_id = $request->presupuestoCFE_id;
            $vehiculo->pConcepto_id = $request->pCFEConcepto_id;
            $vehiculo->cantidad = $request->cantidad;
            $vehiculo->precio = $request->precio_nuevo;
            $vehiculo->precio_v = $request->precio_publico;
            $vehiculo->usuario_id = \Auth::user()->id;
            $vehiculo->remplazar = $request->remplazar;
            $vehiculo->reparar = $request->reparar;
            $vehiculo->fecha_aplicacion = $fecha123;
            $vehiculo->parte = $request->parte;
            $vehiculo->mano_obra = $request->mano_obra;
            $vehiculo->subcontratado = $request->subcontratado;
            $vehiculo->otros = $request->otros;
            $vehiculo->proveedor = $request->proveedor;
            $vehiculo->clave = $request->clave;
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

 
            $sucursal = pCarrito2023::findOrFail($request->id);
            $sucursal->delete();
    
            $estado = true;
            return collect(['estado' => $estado]);
        
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = pCarrito2023::findOrFail($request->id);
        $articulo->cantidad = $request->cantidad;
        $articulo->precio = $request->precio;
        $articulo->precio_v = $request->precio_v;
        $articulo->save();
    }
}
