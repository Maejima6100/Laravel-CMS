<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.permissions.index',['permissions'=>Permission::all()]);
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
            'name'=>'required|string|max:35',
            ]);
        $inputs['slug'] = Str::of(strtolower($inputs['name']))->slug('_');
        $inputs['name'] = ucfirst(strtolower($inputs['name']));
        
        $newPermission = Permission::create($inputs);

        session()->flash('createrolemessage','Permission was sucessfully Created!');
        return back();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
        return view('admin.permissions.edit',['permission'=>$permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
        $inputs = request()->validate([
            'name'=>'required|string|max:35',
            ]);
        
            $inputs['slug'] = Str::of(strtolower($inputs['name']))->slug('_');
            $inputs['name'] = ucfirst(strtolower($inputs['name']));
        
        $permission->update($inputs);

        session()->flash('updaterolemessage','Permission was sucessfully Updated!');
        return redirect(route('permissions.index',['roles'=>Role::all()]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
        $permission->delete();
        session()->flash('deleterolemessage','Permission was sucessfully deleted!');
        return back();
    }
}
