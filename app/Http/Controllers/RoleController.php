<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.roles.index',['roles'=>Role::all()]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = request()->validate([
            'name'=>'required|string|max:25',
            ]);
        $inputs['slug'] = strtolower($inputs['name']);
        
        $newRole = Role::create($inputs);

        $permissions = Permission::all();
        foreach($permissions as $permission){
            $haspermissions = 'permission'. $permission->id;
            if($request->has($haspermissions)){
                $newRole->permissions()->attach($permission->id);
            }
        }
        session()->flash('createrolemessage','Role was sucessfully Created!');
        return back();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        return view('admin.roles.edit',['role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $inputs = request()->validate([
            'name'=>'required|string|max:25',
            ]);
        
        $inputs['name'] = ucfirst(strtolower($inputs['name']));    
        $inputs['slug'] = strtolower($inputs['name']);
        
        $role->update($inputs);
        $role->permissions()->detach();

        $permissions = Permission::all();
        foreach($permissions as $permission){
            $haspermissions = 'permission'. $permission->id;
            if($request->has($haspermissions)){
                $role->permissions()->attach($permission->id);
            }
        }
        session()->flash('updaterolemessage','Role was sucessfully Updated!');
        return redirect(route('roles.index',['roles'=>Role::all()]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();
        session()->flash('deleterolemessage','Role was sucessfully deleted!');
        return back();
    }
}
