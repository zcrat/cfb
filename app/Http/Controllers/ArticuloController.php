<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ArticuloFormRequest;
use App\Articulo;
use App\CodigoSat;
use App\UnidadSat;
use DB;


class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo_sat','articulos.unidad_sat',
            'articulos.unidad','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria',
            'articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->orderBy('articulos.id', 'desc')->paginate(20);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo_sat','articulos.unidad_sat',
            'articulos.unidad','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria',
            'articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(20);
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

    public function buscarcodigos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
     
        $buscar = $request->buscar;
       
        
        if ($buscar==''){
            $codigos = CodigoSat::select('codigo_sat.id','codigo_sat.code','codigo_sat.descripcion')
            ->orderBy('codigo_sat.id', 'asc')->paginate(10);
        }
        else{
            $codigos = CodigoSat::select('codigo_sat.id','codigo_sat.code','codigo_sat.descripcion')
            ->where('codigo_sat.descripcion', 'like', '%'. $buscar . '%')
            ->orderBy('codigo_sat.id', 'asc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $codigos->total(),
                'current_page' => $codigos->currentPage(),
                'per_page'     => $codigos->perPage(),
                'last_page'    => $codigos->lastPage(),
                'from'         => $codigos->firstItem(),
                'to'           => $codigos->lastItem(),
            ],
            'codigos' => $codigos
        ];
    }

    public function buscarunidades(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');
     
        $buscar = $request->buscar;
       
        
        if ($buscar==''){
            $codigos = UnidadSat::select('unidad_sat.id','unidad_sat.code','unidad_sat.nombre','unidad_sat.descripcion')
            ->orderBy('unidad_sat.id', 'asc')->paginate(10);
        }
        else{
            $codigos = UnidadSat::select('unidad_sat.id','unidad_sat.code','unidad_sat.nombre','unidad_sat.descripcion')
            ->where('unidad_sat.nombre', 'like', '%'. $buscar . '%')
            ->orderBy('unidad_sat.id', 'asc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $codigos->total(),
                'current_page' => $codigos->currentPage(),
                'per_page'     => $codigos->perPage(),
                'last_page'    => $codigos->lastPage(),
                'from'         => $codigos->firstItem(),
                'to'           => $codigos->lastItem(),
            ],
            'unidades' => $codigos
        ];
    }

    public function selectArticulo(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $articulos = Articulo::where('descripcion', 'like', '%'. $filtro . '%')
        ->select('id', 'descripcion')->orderBy('descripcion', 'asc')->get();

        return ['articulos' => $articulos];
    }
    public function listarArticulo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo_sat','articulos.unidad_sat',
            'articulos.unidad','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria',
            'articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->orderBy('articulos.id', 'desc')->paginate(20);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo_sat','articulos.unidad_sat',
            'articulos.unidad','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria',
            'articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(20);
        }
        

        return ['articulos' => $articulos];
    }
    public function listarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo_sat','articulos.unidad_sat',
            'articulos.unidad','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria',
            'articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(20);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo_sat','articulos.unidad_sat',
            'articulos.unidad','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria',
            'articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(20);
        }
        

        return ['articulos' => $articulos];
    }
    public function listarPdf(){
        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
        ->select('articulos.id','articulos.idcategoria','articulos.codigo_sat','articulos.unidad_sat',
        'articulos.unidad','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria',
        'articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
        ->orderBy('articulos.nombre', 'desc')->get();

        $cont=Articulo::count();

        $pdf = \PDF::loadView('pdf.articulospdf',['articulos'=>$articulos,'cont'=>$cont]);
        return $pdf->download('articulos.pdf');
    }
    public function buscarArticulo(Request $request ){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id', 'nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['articulos' => $articulos];
    }
    public function buscarArticuloVenta(Request $request ){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=', $filtro)
        ->select('id', 'nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')->take(1)->get();

        return ['articulos' => $articulos];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = new Articulo();
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo_sat = $request->codigo_sat;
        $articulo->unidad_sat = $request->unidad_sat;
        $articulo->unidad = $request->unidad;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo_sat = $request->codigo_sat;
        $articulo->unidad_sat = $request->unidad_sat;
        $articulo->unidad = $request->unidad;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }

}

