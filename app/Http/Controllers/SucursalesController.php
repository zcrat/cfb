<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sucursales; 
use App\Contratos;
use App\FacturasEmisor;
use Illuminate\Support\Facades\Redirect;
use DB;


class SucursalesController extends Controller
{

    public function index(Request $request)
    {
        

        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        $planteles = Contratos::get();
        $emisores= FacturasEmisor::get();
        
        if ($buscar==''){
            $sucursales = Sucursales::orderBy('id', 'desc')->paginate(20);
        }
        else{
            $sucursales = Sucursales::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
        }
        

        return [
            'pagination' => [
                'total'        => $sucursales->total(),
                'current_page' => $sucursales->currentPage(),
                'per_page'     => $sucursales->perPage(),
                'last_page'    => $sucursales->lastPage(),
                'from'         => $sucursales->firstItem(),
                'to'           => $sucursales->lastItem(),
            ],
            'sucursales' => $sucursales,
            'contratos' => $planteles,
            'emisores' => $emisores];
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->imagen==null){
            $fileName = 'sinlogo.png';
           } else {
            $exploded = explode(',', $request->imagen);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'jpeg'))
                $extension = 'jpg';
            else 
                $extension = 'png';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/img/'.$fileName;
    
            file_put_contents($path, $decoded);

           
           }

        

        if (!$request->ajax()) return redirect('/');
        $sucursal = new Sucursales();
        $sucursal->clave = $request->clave;
        $sucursal->nombre = $request->nombre;
        $sucursal->calle = $request->calle;
        $sucursal->numero_ext = $request->numero_ext;
        $sucursal->numero_int = $request->numero_int;
        $sucursal->colonia = $request->colonia;
        $sucursal->cp = $request->cp;
        $sucursal->ciudad = $request->ciudad;
        $sucursal->estado = $request->estado;
        $sucursal->telefono = $request->telefono;
        $sucursal->email = $request->email;
        $sucursal->contratos_id = $request->contratos_id;
        $sucursal->emisor_id = $request->emisor_id;
        $sucursal->logo = $fileName;
        $sucursal->save();

    

        $estado = true;
        return ['Sucursales' => $sucursal, 'estado' => $estado];
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
        if($request->imagen==null){
            $fileName = 'sinlogo.png';
           } else {
            $file = public_path().'/img/'.$request->imagen;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->imagen;
            }

            if ($exists == false){
            $exploded = explode(',', $request->imagen);
            $decoded = base64_decode($exploded[1]);
            if(str_contains($exploded[0], 'jpeg'))
                $extension = 'jpg';
            else 
                $extension = 'png';
            $fileName = str_random().'.'.$extension;
            $path = public_path().'/img/'.$fileName;
            file_put_contents($path, $decoded);
           }
           
           }
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursales::findOrFail($request->id);
        $sucursal->clave = $request->clave;
        $sucursal->nombre = $request->nombre;
        $sucursal->calle = $request->calle;
        $sucursal->numero_ext = $request->numero_ext;
        $sucursal->numero_int = $request->numero_int;
        $sucursal->colonia = $request->colonia;
        $sucursal->cp = $request->cp;
        $sucursal->ciudad = $request->ciudad;
        $sucursal->estado = $request->estado;
        $sucursal->telefono = $request->telefono;
        $sucursal->email = $request->email;
        $sucursal->contratos_id = $request->contrato_id;
        $sucursal->emisor_id = $request->emisor_id;
        $sucursal->logo = $fileName;
        $sucursal->save();

        $estado = true;
        return collect(['estado' => $estado]);


        
    }

    public function delete(Request $request)
    {
       
        $sucursal = Sucursales::findOrFail($request->id);
       
       
        $sucursal->delete();

      
       
        $estado = true;
        return collect(['estado' => $estado]);
    }

    
   

    public function obtenersucursal(Request $request){

       
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;

        $sucursal = Sucursales::where('Sucursales.id','=',$id)->orderBy('id', 'desc')->take(1)->get();


         
        return [
           
            'sucursal' => $sucursal
        ];
    }
    
}
