<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {

        if (Auth::guard($guard)->check()) {
            if(Auth::guard($guard)->user()->role_name=='admin'){
                return redirect('admin/dashboard');
            }
            elseif (Auth::guard($guard)->user()->role_name=='sub_admin') {
                return redirect('subadmin/dashboard');
            }
            else{
                return $next($request);
            }
        }else{
            return $next($request);
        }
    }
}
