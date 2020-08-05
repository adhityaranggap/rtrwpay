<?php

namespace App\Http\Middleware;
use App\User, App\Role;
use Closure;

class AdminBillingOnly
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
        if(auth()->user()->role_id == Role::ROLE_ADMIN){
            return $next($request);
        }elseif(auth()->user()->role_id == Role::ROLE_BILLING){
            return $next($request);
        }else{
            return redirect()->back();
        }    
    }
}
