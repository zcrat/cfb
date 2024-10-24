<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Requests\EmpresaFormRequest;
use Illuminate\Http\Request;
use DB;

class EmpresaController extends Controller
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function index(Request $request)
    {
       

              
        $empresas = Empresa::paginate(10);
       
      
        return [
            'pagination' => [
                'total'        => $empresas->total(),
                'current_page' => $empresas->currentPage(),
                'per_page'     => $empresas->perPage(),
                'last_page'    => $empresas->lastPage(),
                'from'         => $empresas->firstItem(),
                'to'           => $empresas->lastItem(),
            ],
            'empresas' => $empresas
        ];
    }

    //Retornar solo el id y el nombre de la empresa
    public function nombres(){
        $empresas = Empresa::select('id as code','nombre as label')->get();
        return $empresas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function selectEmpresa(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $empresas = Empresa::where('nombre', 'like', '%'. $filtro . '%')
        ->select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        return ['empresas' => $empresas];
    }


    /**
     * @param EmpresaFormRequest $request
     * @return array|\Illuminate\Support\Collection
     */

    public function store(Request $request)
    {
     
       if($request->image==null){
        $fileName = 'sinlogo.png';
       } else {
        $exploded = explode(',', $request->image);

        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg'))
            $extension = 'jpg';
        else 
            $extension = 'png';

        $fileName = str_random().'.'.$extension;

        $path = public_path().'/img/logos-empresas/'.$fileName;

        file_put_contents($path, $decoded);
       }

        $empresa = Empresa::create($request->except('logo') + [
            'logo' => $fileName
        ]);
      
        if ($empresa->id) {
            return collect(
                ['estado' => true, 'empresa' => $empresa]
            );
        }
        return ['estado' => false];
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Support\Collection
     */
    public function update(Request $request)
    {

       

       if ($request->image == ''){

        $fileName = $request->logo;

       } else {

        $exploded = explode(',', $request->image);

        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg'))
            $extension = 'jpg';
        else 
            $extension = 'png';

        $fileName = str_random().'.'.$extension;

        $path = public_path().'/img/logos-empresas/'.$fileName;

        file_put_contents($path, $decoded);
       }
        $empresa = Empresa::find($request->id);
        $empresa->nombre = $request->nombre;
        $empresa->rfc = $request->rfc;
        $empresa->logo = $fileName;
        $empresa->email = $request->email;
        $empresa->direccion = $request->direccion;
        $empresa->ciudad = $request->ciudad;
        $empresa->estado = $request->estado;
        $empresa->cp = $request->cp;
        $empresa->tel_negocio = $request->tel_negocio;
        $empresa->tel_casa = $request->tel_casa;
        $empresa->tel_celular = $request->tel_celular;
        $empresa->regimen = $request->regimen;
        $empresaTemp = $empresa;
        $status = $empresa->save();
        return collect(['estado' => $status, 'empresa' => $empresaTemp]);
    }

    public function search(Request $request)
    {
        $model = new Empresa();
        $consulta = null;
        $firstTime = true;
        if ($request->get('busqueda')) {
            foreach ($model->getFillable() as $atributo) {
                if ($firstTime) {
                    $firstTime = false;
                    $consulta = Empresa::where($atributo, 'LIKE', "%$request->busqueda%");
                } else {
                    $consulta->orWhere($atributo, 'LIKE', "%$request->busqueda%");
                }
            }
            $consulta->paginate(10);
          
           
            return ['estado' => true, 'empresas' => $consulta->get()];
        } else {
            return collect(['estado' => false]);
        }
    }

    public function destroy(Request $request)
    {
        $empresa = Empresa::findOrFail($request->id);
        //Eliminamos los clientes de esa empresa
        $empresa->customers()->delete();
        $estado = $empresa->delete();
        return collect(['estado' => $estado]);
    }

    public function customers($empresa_id){
        $empresa = Empresa::find($empresa_id);
        $empresaCustomers = $empresa->customers;
        $customers = collect();
        foreach($empresaCustomers as $customer){
            $customers->push(['code' => $customer->id,'label' => $customer->nombre]);
        }
        return $customers;
    }
}
