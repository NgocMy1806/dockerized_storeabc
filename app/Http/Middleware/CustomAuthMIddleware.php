<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory ;
use Illuminate\Support\Facades\Auth;

class CustomAuthMIddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard)
    {
        if(!Auth::guard($guard)->check()){
            if($guard=='admin'){
                return redirect()->route('admin.login')->withErrors(['login'=>'msg abc']);

            }
            return redirect()->route('login')->withErrors(['login'=>'bạn phải là admin mới đăng nhập dcd']);

        }
        return $next($request);

    }
}
