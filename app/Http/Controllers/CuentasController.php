<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuentas;
use App\Bancos;
use App\Monedas;
use App\TiposCuenta;

class CuentasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $bancos = Bancos::get();
        $tiposCuenta = TiposCuenta::get();
        $monedas = Monedas::get();
        
        if ($buscar==''){
            $categorias = Cuentas::join('bancos','cuentas.bancos_id','=','bancos.id')
            ->join('tiposCuenta','cuentas.tiposCuenta_id','=','tiposCuenta.id')
            ->join('monedas','cuentas.monedas_id','=','monedas.id')
            ->select('cuentas.id','cuentas.noCuenta','bancos.nombre as banco','tiposCuenta.nombre as tipoCuenta','monedas.nombre as moneda','cuentas.bancos_id','cuentas.tiposCuenta_id','cuentas.monedas_id',
            'cuentas.domicilioBanco','cuentas.telefonoBanco','cuentas.nombreEjecutivo','cuentas.emailEjecutivo','cuentas.telefonoEjecutivo')
            ->orderBy('id', 'desc')->paginate(3);
        }
        else{
            $categorias = Cuentas::join('bancos','cuentas.bancos_id','=','bancos.id')
            ->join('tiposCuenta','cuentas.tiposCuenta_id','=','tiposCuenta.id')
            ->join('monedas','cuentas.monedas_id','=','monedas.id')
            ->select('cuentas.id','cuentas.noCuenta','bancos.nombre as banco','tiposCuenta.nombre as tipoCuenta','monedas.nombre as moneda','cuentas.bancos_id','cuentas.tiposCuenta_id','cuentas.monedas_id',
            'cuentas.domicilioBanco','cuentas.telefonoBanco','cuentas.nombreEjecutivo','cuentas.emailEjecutivo','cuentas.telefonoEjecutivo')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
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
            'categorias' => $categorias,
            'bancos' => $bancos,
            'tiposCuenta' => $tiposCuenta,
            'monedas' => $monedas,
        ];
    }

    public function selectCuentas(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Cuentas::select('id','nombre')->orderBy('nombre', 'asc')->get();
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
        $categoria = new Cuentas();
        $categoria->noCuenta = $request->noCuenta;
        $categoria->bancos_id = $request->bancos_id;
        $categoria->tiposCuenta_id = $request->tiposCuenta_id;
        $categoria->monedas_id = $request->monedas_id;
        $categoria->domicilioBanco = $request->domicilioBanco;
        $categoria->telefonoBanco = $request->telefonoBanco;
        $categoria->nombreEjecutivo = $request->nombreEjecutivo;
        $categoria->emailEjecutivo = $request->emailEjecutivo;
        $categoria->telefonoEjecutivo = $request->telefonoEjecutivo;
        $categoria->save();
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
        $categoria = Cuentas::findOrFail($request->id);
        $categoria->noCuenta = $request->noCuenta;
        $categoria->bancos_id = $request->bancos_id;
        $categoria->tiposCuenta_id = $request->tiposCuenta_id;
        $categoria->monedas_id = $request->monedas_id;
        $categoria->domicilioBanco = $request->domicilioBanco;
        $categoria->telefonoBanco = $request->telefonoBanco;
        $categoria->nombreEjecutivo = $request->nombreEjecutivo;
        $categoria->emailEjecutivo = $request->emailEjecutivo;
        $categoria->telefonoEjecutivo = $request->telefonoEjecutivo;
        $categoria->save();
    }
}
