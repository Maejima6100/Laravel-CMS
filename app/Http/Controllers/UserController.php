<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index',['users'=>$users]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();
        return view('admin.users.profile',['user'=>$user,'roles'=>Role::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.users.editprofile',['user'=>User::find($id),'roles'=>Role::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $user = auth()->user();
        $inputs = request()->validate([
            'username'=>'required|string|max:250|alpha_dash',
            'name'=>'required|string|max:250',
            'password'=>'required|string|confirmed|min:8|max:250',
            'email'=>'required|email|max:250',
            'role_id'=>'required',
            'avatar'=>'file'
            ]);

        //Avatar image Check and Set
        //Checking to see if the current avatar image file is in use by other users
        $allusers = User::all();
        $fileusers = 0;
        foreach($allusers as $auser){
            if($auser->avatar == $user->avatar) $fileusers++ ;
        }
        ($fileusers < 2) ? $fileinuse = false : $fileinuse = true;

        //checking to see if there is a file in the avatar request 
        //then set the new file and delete the old one if its not in use
        if($file = request('avatar')){
            $newfile = 'storage/avatars/' . $file->getClientOriginalName();
            if(!file_exists('$newfile')){
                $inputs['avatar'] = $file->storeAs('avatars',$file->getClientOriginalName());
                if(!$fileinuse) Storage::delete($user->getAttributes()['avatar']);
            }
            $inputs['avatar'] = 'avatars/' . $file->getClientOriginalName();
        } else {
            $inputs['avatar'] = 'avatars/noavatar.jpg';
            if(!$fileinuse) Storage::delete($user->getAttributes()['avatar']);       
        }

        //checking to see if the role changes and then detach the old and attach the new role
        $newrole = Role::find($inputs['role_id']);
        if ($user->role_id !== $newrole->id) { 
            $user->roles()->detach();
            $user->roles()->attach($newrole->id);
            $user->role_id = $newrole->id;
            $user->save();
        }

        //finally updating the user and setting the flash message
        $user->update($inputs);
        session()->flash('updateusermessage','User settings were sucessfully updated!');
        return back(); 
    }

    public function updateUsers(Request $request, User $user)
    {
        $inputs = request()->validate([
            'username'=>'required|string|max:250|alpha_dash',
            'name'=>'required|string|max:250',
            'password'=>'required|string|confirmed|min:8|max:250',
            'email'=>'required|email|max:250',
            'role_id'=>'required',
            'avatar'=>'file'
            ]);

        //Avatar image Check and Set
        //Checking to see if the current avatar image file is in use by other users
        $allusers = User::all();
        $fileusers = 0;
        foreach($allusers as $auser){
            if($auser->avatar == $user->avatar) $fileusers++ ;
        }
        ($fileusers < 2) ? $fileinuse = false : $fileinuse = true;

        //checking to see if there is a file in the avatar request 
        //then set the new file and delete the old one if its not in use
        if($file = request('avatar')){
            $newfile = 'storage/avatars/' . $file->getClientOriginalName();
            if(!file_exists('$newfile')){
                $inputs['avatar'] = $file->storeAs('avatars',$file->getClientOriginalName());
                if(!$fileinuse) Storage::delete($user->getAttributes()['avatar']);
            }
            $inputs['avatar'] = 'avatars/' . $file->getClientOriginalName();
        } else {
            $inputs['avatar'] = 'avatars/noavatar.jpg';
            if(!$fileinuse) Storage::delete($user->getAttributes()['avatar']);       
        }   
        

        //checking to see if the role changes and then detach the old and attach the new role
        $newrole = Role::find($inputs['role_id']);
        if ($user->role_id !== $newrole->id) { 
            $user->roles()->detach();
            $user->roles()->attach($newrole->id);
            $user->role_id = $newrole->id;
            $user->save();
        }

        //finally updating the user and setting the flash message
        $user->update($inputs);
        session()->flash('updateusermessage','User settings were sucessfully updated!');
        return back(); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //Avatar image Check and delete
        //Checking to see if the current avatar image file is in use by other users
        $allusers = User::all();
        $fileusers = 0;
        foreach($allusers as $auser){
            if($auser->avatar == $user->avatar) $fileusers++ ;
        }
        ($fileusers < 2) ? $fileinuse = false : $fileinuse = true;
        //delete the users avatar image if it is not used by another account
        if(!$fileinuse) Storage::delete($user->getAttributes()['avatar']);      
        $user->delete();
        session()->flash('deleteusermessage','User was sucessfully deleted!');
        return back();
    }
}
