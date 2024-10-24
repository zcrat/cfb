<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Productos;
use App\Articulo;
use App\ProductosGrupos;
use App\ClientesGrupos;

class ProductosGruposController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = ProductosGrupos::join('productos','productos_grupos.productos_id','=','productos.id')
            ->join('grupos','productos_grupos.grupos_id','=','grupos.id')
            ->select('productos_grupos.id','productos_grupos.productos_id','productos_grupos.grupos_id','productos_grupos.precio',
            'productos.strdescripcion','productos.cantidad','grupos.nombre')
            ->orderBy('productos_grupos.id', 'desc')->paginate(20);
        }
        else{
            $articulos = Productos::join('productos','productos_grupos.productos_id','=','productos.id')
            ->join('grupos','productos_grupos.grupos_id','=','grupos.id')
            ->select('productos_grupos.id','productos_grupos.productos_id','productos_grupos.grupos_id','productos_grupos.precio',
            'productos.strdescripcion','productos.cantidad','grupos.nombre')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos_grupos.id', 'desc')->paginate(20);
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
        $articulo = new ProductosGrupos();
        $articulo->productos_id = $request->productos_id;
        $articulo->grupos_id = $request->grupos_id;
        $articulo->precio = $request->precio;
        $articulo->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = ProductosGrupos::findOrFail($request->id);
        $articulo->productos_id = $request->productos_id;
        $articulo->grupos_id = $request->grupos_id;
        $articulo->precio = $request->precio;
        $articulo->save();
    }

    public function listarProductos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        $clientesGrupo = ClientesGrupos::select('clientes_grupos.grupos_id')
        ->where('clientes_grupos.empresa_id', '=', $request->empresas_id )->get();
  
        if ($buscar==''){
            $articulos = ProductosGrupos::join('productos','productos_grupos.productos_id','=','productos.id')
            ->join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigosat','productos.unidadsat',
            'productos.unidad','productos.strcodigo','productos.strdescripcion as nombre','categorias.nombre as nombre_categoria',
            'productos_grupos.precio','productos.cantidad')
            ->where('productos_grupos.grupos_id','=',$clientesGrupo[0]->grupos_id)
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $articulos =  ProductosGrupos::join('productos','productos_grupos.productos_id','=','productos.id')
            ->join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigosat','productos.unidadsat',
            'productos.unidad','productos.strcodigo','productos.strdescripcion as nombre','categorias.nombre as nombre_categoria',
            'productos_grupos.precio','productos.cantidad')
            ->where('productos_grupos.grupos_id','=',$clientesGrupo[0]->grupos_id)
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return ['articulos' => $articulos];
    }
}
