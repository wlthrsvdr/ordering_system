<?php

namespace App\Laravel\Middleware\System;

use Closure;
use Illuminate\Support\Facades\Auth;

class PendingActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            if(Auth::user()->is_default_password == "yes"){
                session()->flash('notification-status', "warning");
                session()->flash('notification-msg', "Please activate account first before you continue using the platform.");
                return redirect()->route('system.auth.activate');
            }
            // return redirect()->route('system.index');
        }
        return $next($request);
    }
}
