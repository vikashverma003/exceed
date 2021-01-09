<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::guard('admin')->user()->isAdmin()){
            if($request->ajax()){
                return response()->json(['status'=>false,'message'=>"You don'\t have permission to access."], 400);
            }else{
                flash("You don'\t have permission to access.")->error()->important();
                return redirect('admin/dashboard');
            }
        }else{
            return $next($request);
        }
    }
}
