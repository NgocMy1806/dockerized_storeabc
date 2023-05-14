<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm(){
        return view('admin.auth.login');
    }
    public function login(Request $request){
        // dd($request->all());

        // $request->validate([
        //     'name'=>['required|min:2'],
        //     'password'=>['required|min:3'],
        // ],[
        //     'name.required'=>'Please input name',
        //     'name.min'=>'Please input more than 2 characters',
        //     'password.required'=>'Please input password',
        //     'password.min'=>'Please input more than 2 characters',
        // ]);

        $credential=[
            'name'=>$request->input('name'),
            'password'=>$request->input('password'),
        ];
        //  dd(bcrypt('12345678'));
         $user = Auth::guard('admin')->attempt($credential);
       
        // dd($user);

        if ($user){
            return redirect()->route('dashboard');
        }

        return redirect()->route('admin.login');
        
}
public function logout(){
    Auth::guard('admin')->logout();
    return redirect()->route('admin.login')->with('success','Logout Successfully');
}
}
