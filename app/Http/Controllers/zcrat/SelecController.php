<?php

namespace App\Http\Controllers\zcrat;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Articulo;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\TipoAuto;
use App\Models\Vehiculo;
use App\Models\usercajaModel;
use App\Models\Ubicaciones;
use App\Models\TiposDisponibles;
use App\Models\TiposDisponibles2;
use App\Models\AdministradorTransporte;
use App\Models\JefeDeProceso;
use App\Models\TecnicoTaller;
use App\Models\Trabajador;
use App\CodigoSat;
use App\pCFETipos;
use App\pCFECategorias;
use Illuminate\Support\Facades\DB;
use App\RecepcionVehicular;

class SelecController extends Controller
{
    public function select2empresas(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Empresa::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(15)->get();
        return response()->json($s2empresas);
    }
    public function obtenerarticulos(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $articulos=Articulo::select('id','descripcion')->where('descripcion', 'like', '%' . $term . '%')->take(15)->get();
        
        return response()->json($articulos);
        }
    public function select2rr(Request $request){
            $term = str_replace(' ', '%', $request->input('term'));
            $rr=RecepcionVehicular::select('id','folioNum')->where('folioNum', 'like', '%' . $term . '%')->orderby("folioNum","desc")->take(15)->get();
            return response()->json($rr);
            }
    public function select2clientes(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Customer::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(15)->get();
        return response()->json($s2empresas);
    }
    public function select2vehiculos(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $vehiculos=Vehiculo::select('id',DB::raw("CONCAT(no_economico, '-',placas) as nombre"))->where('placas','LIKE','%'.$term.'%')->orwhere('no_economico','LIKE','%'.$term.'%')->take(15)->get();
        return response()->json($vehiculos);
    }
    public function select2marcasvehiculo(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Marca::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(15)->get();
        return response()->json($s2empresas);
    }
    public function select2modelosvehiculo(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=Modelo::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->where('marca_id',$request->input('marcaid'))->take(15)->get();
        return response()->json($s2empresas);
    }
    public function select2tipovehiculo(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $s2empresas=TipoAuto::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(15)->get();
        return response()->json($s2empresas);
    }
    public function select2coloresvehiculo(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $colores=Color::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(15)->get();
        return response()->json($colores);
    }
    public function select2ubicaciones(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $Ubicaciones=Ubicaciones::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->take(15)->get();
        return response()->json($Ubicaciones);
    }
    public function select2catalogosproductos(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $productos=CodigoSat::select('id','descripcion')->where('descripcion','LIKE','%'.$term.'%')->get();
        return response()->json($productos);
    }
    public function select2tiposproductos(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $modulo= $request->input('modulo');
        $contrato= $request->input('contrato');
        $tipos_disponibles=TiposDisponibles::where('id_modulo',$modulo)->where('id_sucursal',$contrato)->pluck('id_tipo');
        $tipos = pCFETipos::wherein('id',$tipos_disponibles)->where('tipo','LIKE','%'.$term.'%')->orderBy('tipo', 'asc')->get();
        
        return response()->json($tipos);
    }
    public function select2tiposproductos2(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $modulo= $request->input('modulo');
        $anio= $request->input('anio');
        $zona= $request->input('zona');
        $contrato= $request->input('contrato');
        $tipos_disponibles=TiposDisponibles2::where('id_modulo',$modulo)->where('id_contrato',$contrato)->where('anio',$anio)->where('id_zona',$zona)->pluck('id_tipo');
        $tipos = pCFETipos::wherein('id',$tipos_disponibles)->where('tipo','LIKE','%'.$term.'%')->orderBy('tipo', 'asc')->get();
        
        return response()->json($tipos);
    }
    public function select2todostiposproductos(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $modulo = $request->input('modulo');
        $contrato = $request->input('contrato');
        
        // Comienza la consulta
        $query = TiposDisponibles::query();
        
        // Añade condiciones dinámicamente
        if (!empty($modulo)) {
            $query->where('id_modulo', $modulo);
        }
        
        if (!empty($contrato)) {
            $query->where('id_sucursal', $contrato);
        }
        
        // Obtén los resultados
        $tipos_disponibles = $query->pluck('id_tipo');
        
        $tipos = pCFETipos::wherein('id',$tipos_disponibles)->where('tipo','LIKE','%'.$term.'%')->orderBy('tipo', 'asc')->get();
        
        return response()->json($tipos);
    }
    public function select2categoriaproductos(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        //$modulo= $request->input('modulo');
        $modulo= 1;
        // if(\Auth::user()->id == 1){
        //     $categorias = pCFECategorias::where('CFE_id',$modulo)->where('titulo','LIKE','%'.$term.'%')->orderBy('titulo', 'asc')->take(10)->get();
        // } else {
            $categorias = pCFECategorias::where('CFE_id',$modulo)->where('titulo','LIKE','%'.$term.'%')->where('sucursal_id','=',1)->orderBy('titulo', 'asc')->get();
        // }
        return response()->json($categorias);
    }

    public function select2usuarioscaja(Request $request){
        $term = str_replace(' ', '%', $request->input('term'));
        $productos=usercajaModel::select('id','name')->where('name','LIKE','%'.$term.'%')->get();
        return response()->json($productos);
    }
    public function select2usuariostaller(Request $request){
        $tipo=$request->origen?:'nullo';
        switch($tipo){
            case 'Administrador de Trasportes':
                $usertaller=new AdministradorTransporte();
                break;
            case 'Jefe de Proceso':
                $usertaller=new JefeDeProceso();
                break;        
            case 'Tecnico':
                $usertaller=new TecnicoTaller();
                break;
            default:
                $usertaller=new Trabajador();
                break;
        };
        $term = str_replace(' ', '%', $request->input('term'));
        $productos=$usertaller::select('id','nombre')->where('nombre','LIKE','%'.$term.'%')->get();
        return response()->json($productos);
    }
}