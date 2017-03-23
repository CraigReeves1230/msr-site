<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminVerify
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
        // redirect if guest
        if(Auth::guest()){
            return redirect('/');
        }

        // redirect if not admin
        if(Auth::user()->admin != 1){
            return redirect('/');
        }

        return $next($request);
    }
}
