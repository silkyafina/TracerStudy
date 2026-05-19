<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AlumniMiddleware
{
    public function handle($request, Closure $next)
{
    if (!Auth::check() || Auth::user()->role !== 'alumni') {
        return redirect()->route('alumni.login');
    }

    return $next($request);
}
}
