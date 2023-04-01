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
        $credential=[
            'name'=>$request->input('name'),
            'password'=>$request->input('password'),
        ];
         dd($credential);
        // $user = Auth::guard('admin')->attempt($credential);
        $user=Auth::guard('admin')->validate($credential);
        dd($user);
        if ($user){
            return redirect()->route('dashboard');
        }
        return redirect()->route('admin.login');
}
}
