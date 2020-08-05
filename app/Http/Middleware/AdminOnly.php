<?php

namespace App\Http\Middleware;
use App\User, App\Role;
use Closure;

class AdminOnly
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
        // $user = User::where('email', $request->email)->first();
        // if (auth()->user()->role_id == ROLE::ROLE_WARGA) {
        //     return redirect('ticket/all-ticket');
        // } elseif (auth()->user()->role_id != ROLE::ROLE_WARGA) {
        //     return redirect('transactions/all-transaction');
        // }

        if(auth()->user()->role_id == Role::ROLE_ADMIN){
            return $next($request);
        }else{
            return redirect()->back();
        }

        
    }
}
