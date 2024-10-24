<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Productos;
use App\CodigoSat;
use App\UnidadSat;
use DB;

class ProductosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Productos::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.strdescripcion','productos.cantidad','productos.intprecio','categorias.nombre as categoria',
            'productos.codigosat', 'productos.unidadsat','productos.idcategoria','productos.strcodigo','productos.unidad')
            ->orderBy('productos.id', 'desc')->paginate(20);
        }
        else{
            $articulos = Productos::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.strdescripcion','productos.cantidad','productos.intprecio','categorias.nombre as categoria',
            'productos.codigosat', 'productos.unidadsat','productos.idcategoria','productos.strcodigo','productos.unidad')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(20);
        }
        

        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }

    public function store(Request $request)
    {
    
        if (!$request->ajax()) return redirect('/');
        $articulo = new Productos();
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigosat = $request->codigo_sat;
        $articulo->unidadsat = $request->unidad_sat;
        $articulo->unidad = $request->unidad;
        $articulo->strdescripcion = $request->descripcion;
        $articulo->strcodigo = $request->codigo;
        $articulo->cantidad = $request->stock;
        $articulo->intprecio = $request->precio_venta;
        $articulo->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Productos::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigosat = $request->codigo_sat;
        $articulo->unidadsat = $request->unidad_sat;
        $articulo->unidad = $request->unidad;
        $articulo->strdescripcion = $request->descripcion;
        $articulo->strcodigo = $request->codigo;
        $articulo->cantidad = $request->stock;
        $articulo->intprecio = $request->precio_venta;
        $articulo->save();
    }

    public function selectProductos(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Productos::select('id','strdescripcion')->orderBy('strdescripcion', 'asc')->get();
        return ['productos' => $categorias];
    }
}
