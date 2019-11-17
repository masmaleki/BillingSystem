<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showUsers(){

        if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("operator"))
        {
            $users = User::all();
            return view('users',compact('users'));
        }
        else
        {
            session()->flash('status', 'You have NOT access for this operation');
            return redirect()->route('home',app()->getLocale());
        }
    }
    public function createUser(){
        $roles = Role::all();
        ///check Access
        if(Auth::user()->hasRole("admin"))
        {
            return view('createUser',compact('roles'));
        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('home',app()->getLocale());
        }



    }
    public function doCreateUser(Request $request){

        ///check Access
        if(Auth::user()->hasRole("admin"))
        {
            $name = $request->post('name');
            $email = $request->post('email');
            $role_id = $request->post('role');
            $password = $request->post('password');

            $newUser = new User();
            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->role_id = $role_id;
            $newUser->password= Hash::make($password);
            $newUser->save();
            session()->flash('status', 'New User Created Successfully');
            return redirect()->route('users',app()->getLocale());
        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('home',app()->getLocale());
        }



    }
    public function deleteUser($local , $id){

        ///check Access
        if(Auth::user()->hasRole("admin"))
        {

            User::find($id)->delete();
            session()->flash('status', 'User Deleted Successfully');
            return redirect()->route('users',app()->getLocale());
        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('home',app()->getLocale());
        }



    }
    public function editUser($local , $id){
        $user = User::find($id);

        ///check Access
        if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("operator"))
        {
            if(Auth::user()->hasRole("admin")){
                $roles = Role::all();
            }else{
                $roles = Role::where('id','!=',1)->get();
            }
            if($user->hasRole("admin")){
                session()->flash('status', 'You can not change SuperAdmin users');
                return redirect()->route('users',app()->getLocale());
            }else{
                return view('editUser',compact('roles','user'));
            }

        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('home',app()->getLocale());
        }



    }
    public function doEditUser(Request $request,$local , $id){

        ///check Access
        if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("operator"))
        {
            $name = $request->post('name');
            $email = $request->post('email');
            $role_id = $request->post('role');
            $password = $request->post('password');

            $User = User::find($id);
            $User->name = $name;
            $User->email = $email;
            $User->role_id = $role_id;
            if($password != null){
                $User->password= Hash::make($password);
            }
            $User->update();
            session()->flash('status', 'User Information Edited Successfully');
            return redirect()->route('users',app()->getLocale());
        }
        else
        {
            session()->flash('status', 'You have Not access for this operation');
            return redirect()->route('home',app()->getLocale());
        }



    }
    public function doChangePassword(Request $request){

        $password = $request->post('password');
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        session()->flash('status', 'Your Password Change Successfully');
        return redirect()->route('home',app()->getLocale());

    }

}
