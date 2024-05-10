<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Preferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Gate;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $usr = new User();
        $usr->setConnection('mysql1');
        $pref = new Preferences();
        $pref->setConnection('mysql1');
        $users = $usr->all();
        $valid_pref = $pref->where('name','validation')->get()->first()->enable;
        $delete_admin = $pref->where('name','delete-admin')->get()->first()->enable;
        $deac_admin = $pref->where('name','deac-admin')->get()->first()->enable;
        return view('admin.users.index',compact('users','valid_pref','delete_admin','deac_admin'));//->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Gate::denies('edit-user'))
            return redirect()->route('admin.users.index');
        $role = new Role();
        $role->setConnection('mysql1');
        $roles = $role->all();
        return view('admin.users.edit')->with(
            [
                'user' => $user,
                'roles' => $roles,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(Gate::allows('edit-user'))
            $user->roles()->sync($request->roles);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(Gate::allows('delete-user')){
            $native = $user->id == auth()->user()->id;
            $user->roles()->detach();
            $user->delete();
            if(Session::has($user->id))
                Session::forget($user->id);
            if($native)
                return redirect()->route('welcome');
        }
        return redirect()->route('admin.users.index');
    }
    public function activate(User $user){
        if(Gate::allows('edit-user')){

                $user->activated = true;
                $user->save();

        }
        return redirect()->route('admin.users.index');
    }
    public function deactivate(User $user){
        if(Gate::allows('edit-user')){
            $user->activated = false;
            $user->save();
            session(
                [
                    $user->id => 'man',
                ]
            );
        }
        return redirect()->route('admin.users.index');
    }
}
