<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//adicion
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{

    // Constructor del controlador
    public function __construct()
    {
        // Middleware para verificar permisos
        // Solo permite acceso a la acción 'index' si el usuario tiene alguno de los permisos especificados
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|borrar-rol', ['only' => ['index']]);
        
        // Solo permite acceso a las acciones 'create' y 'store' si el usuario tiene el permiso 'crear-rol'
        $this->middleware('permission:crear-rol', ['only' => ['create', 'store']]);
        
        // Solo permite acceso a las acciones 'edit' y 'update' si el usuario tiene el permiso 'editar-rol'
        $this->middleware('permission:editar-rol', ['only' => ['edit', 'update']]);
        
        // Solo permite acceso a la acción 'destroy' si el usuario tiene el permiso 'borrar-rol'
        $this->middleware('permission:borrar-rol', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view ('roles.crear', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required']);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Busca el rol por su id
        $role = Role::find($id);
        // Obtiene todos los permisos
        $permission = Permission::get();
        // Obtiene los permisos asignados al rol
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            // Pluck recupera todos los valores de una clave dada
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        // Retorna la vista de edición con los datos del rol, los permisos y los permisos asignados al rol    
        return view('roles.editar', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Valida los datos del formulario
        $this->validate($request, [
            'name' => 'required','permission' => 'required']);
        // Busca el rol por su id
        $role = Role::find($id);
        // Actualiza el nombre del rol
        $role->name = $request->input('name');
        // Guarda los cambios
        $role->save();

        // Sincroniza los permisos del rol
        $role->syncPermissions($request->input('permission'));

        // Redirecciona a la vista de roles con un mensaje de éxito
        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente');
    }
}
