<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use App\User;
use App\permissionRole;

class RolController extends Controller
{
    public function index(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        $permissions = Permission::get();
        
        if ($buscar==''){
   
            $roles = Role::orderBy('id')->paginate(10);
         
        }
        else{
            $roles = Role::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page'     => $roles->perPage(),
                'last_page'    => $roles->lastPage(),
                'from'         => $roles->firstItem(),
                'to'           => $roles->lastItem(),
            ],
            'roles' => $roles,
            'permissions' => $permissions
        ];
    }

    public function store(Request $request){

       
        $role = Role::create($request->post('rol'));
        
        $role->permissions()->sync($request->post('per'));

        if ($role->id) {
            return collect(
                ['estado' => true, 'roles' => $role]
            );
        }
        return ['estado' => false];
    }

    public function edit(Request $request, Role $rol){

       

        $id = $request->all();
        

        $rol = Role::findOrFail($request->id);
       
    
        $permisos = Permission::get();

        

        $perm = permissionRole::join('permissions','permission_role.permission_id','=','permissions.id')
        ->select('permission_role.permission_id as id')
        ->where('permission_role.role_id','=',$request->id)->get();

       
        $permis = array();

        for($i = 0; $i < count($perm); ++$i) {
            $permis[$i] = $perm[$i]['id'];
        }

       
        return ['roles' => $rol,
                'permisos' => $permisos,
                'permisoscheck' => $permis ];
                
    }

    public function update(Request $request){
         

        $role = Role::findOrFail($request->rol['id']);
        $role->name = $request->rol['name'];
        $role->slug = $request->rol['slug'];
        $role->description = $request->rol['description'];
        $role->special = $request->rol['special'];
        $role->save();

        $role->permissions()->sync($request->per);
       
        return  $role->id;

    }


    public function selectRol(Request $request)
    {
        $roles = Rol::where('condicion', '=', '1')
        ->select('id','nombre')
        ->orderBy('name', 'asc')->get();

        return ['roles' => $roles];
    } 
}
