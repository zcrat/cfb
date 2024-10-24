<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contratos; 
use DB;

class ContratosController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $categorias = Contratos::orderBy('id', 'desc')->paginate(20);
        }
        else{
            $categorias = Contratos::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
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
            'contratos' => $categorias
        ];
    }

    public function selectCategoria(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Contratos::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['categorias' => $categorias];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = new Contratos();
        $categoria->nombre = $request->nombre;
        $categoria->numero = $request->numero;
        $categoria->monto = $request->monto;
        $categoria->save();

        $estado = true;
        return ['Sucursales' => $categoria, 'estado' => $estado];
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Contratos::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->numero = $request->numero;
        $categoria->monto = $request->monto;
        $categoria->save();

        $estado = true;
        return ['estado' => $estado];
    }
}
