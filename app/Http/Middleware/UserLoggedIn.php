<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class UserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard=null)
    {
        if (Auth::guard($guard)->check()) {

            $roles = Role::where('guard','web')->pluck('id')->toArray();

            if(in_array(Auth::user()->role_id, $roles)){
                return $next($request);
            }
            else{
                if($request->expectsJson()){
                    return response()->json(['status'=>false,'message'=>'Sorry, You are not allowded.'], 400);
                }else{
                    Auth::logout();
                    return redirect('/');
                }
            }
        }else{
            return $next($request);
        }
    }
}
