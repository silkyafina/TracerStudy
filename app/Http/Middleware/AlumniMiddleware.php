<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AlumniMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('alumni')->check()) {
            return redirect()->route('alumni.login');
        }

        return $next($request);
    }
}
