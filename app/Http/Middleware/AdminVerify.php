<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

        // redirect if banned
        if(Auth::user()->status == "banned"){
            if(Auth::user()->master == 0) {
                Session::flash('banned_admin',
                    'Your account has been banned. You are no longer allowed to visit the administrator page.');
                return redirect('/');
            }
        }

        return $next($request);
    }
}
