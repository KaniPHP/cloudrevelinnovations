<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role == 'user') {
            return $next($request);
        }
        return redirect()->route('login')->with('error', 'Access Denied!');
    }
}
