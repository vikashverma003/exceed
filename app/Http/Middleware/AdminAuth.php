<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::guard($guard)->user()->role_name=='admin'){
                return $next($request);
            }
            elseif (Auth::guard($guard)->user()->role_name=='sub_admin') {
                return $next($request);
            }
            else{
                Auth::logout();
                // flash('Sorry! You are not the authorised user.')->error();
                return redirect('admin/login');
            }
        }else{
            Auth::logout();
            // flash('Sorry! You are not the authorised user.')->error();
            return redirect('admin/login');
        }     
    }
}
