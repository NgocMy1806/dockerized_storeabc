<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    //     public function handle($request, Closure $next, ...$guards)
    //     {
    //         $guard=$guards[0];
    //         dd($this->Auth::guard('$guard')->check());
    //        if($this->auth->guard($guard)->check()){
    //         return $guard?route('admin.login'):route('login');

    //     }
    // }
    public function redirectTo($request)
    {
        if ($this->auth::guard('admin')->check()) {
            return route('admin.login');
        }
        return route('login');
    }
}
