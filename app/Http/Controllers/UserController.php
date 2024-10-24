<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use App\User;
use App\Sucursales;
use App\roleUser;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;

class UserController extends Controller
{


    public function index(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        $roles = Role::get();

        $planteles = Sucursales::get();
        
        if ($buscar==''){
            $personas = User::join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('roles','role_user.role_id','=','roles.id')
            ->select('users.id','users.name as nombre','users.email','users.password','users.condicion','sucursales.nombre as sucursal','roles.name as rol')
            ->orderBy('users.id', 'desc')->paginate(20);
        }
        else{
            $personas = User::join('sucursales','users.sucursal_id','=','sucursales.id')
            ->select('users.id','users.name as nombre','users.email','users.password','users.condicion','sucursales.nombre as sucursal')
            ->where('users.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
        }
        
        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas,
            'roles' => $roles,
            'planteles' => $planteles  
        ];
    }

    public function store(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

        
         
            $user = new User();
            $user->sucursal_id = $request->planteles_id;
            $user->name = $request->nombre;
            $user->email = $request->email;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';            
            $user->save();
           
          
        
            $user->roles()->sync($request->post('roles'));
         


            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function edit(Request $request){


        $id = $request->all();
        $user = User::findOrFail($request->id);
        $roles = Role::get();

    
        $rol = roleUser::join('roles','role_user.role_id','=','roles.id')
        ->select('role_user.role_id as id')
        ->where('role_user.user_id','=',$request->id)->get();

       
        $rolesc = array();

        for($i = 0; $i < count($rol); ++$i) {
            $rolesc[$i] = $rol[$i]['id'];
        }

       
        return ['persona' => $user,
                'roles' => $roles,
                'rolescheck' => $rolesc ];
                
    }

    public function update(Request $request)
    {

     
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $user = User::findOrFail($request->id);
            $user->sucursal_id = $request->planteles_id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->save();


            $user->roles()->sync($request->roles);
           
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        // $user = User::findOrFail($request->id);
        // $user->condicion = '0';
        // $user->save();
        $sucursal = User::findOrFail($request->id);
        $sucursal->delete();
        $estado = true;
        return collect(['estado' => $estado]);
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }

    public function login(Request $request)
    {   
    

        $personas = User::select('users.id','users.name as nombre','users.email','users.password','users.condicion','users.created_at','users.sucursal_id')
        ->where('users.email','=',$request->user)->first();
      
        
      
        if($personas == null){
            return ['success' => '0',
            'mensaje' => 'Su correo no esta registrado'];
        } else {
        if(Hash::check($request->password, $personas->password)){
            
            $alumno = User::findOrFail($personas->id);
            $alumno->token = $request->token;
            $alumno->save();
            
            return ['user' => $personas,    
                'success' => '1',
                'user_id' => $personas->id,
                'mensaje' => 'Ingreso exitoso'];
        } else {
            return ['success' => '0',
                'mensaje' => 'Password incorrectO'];
        }
        }
       
    }
}
