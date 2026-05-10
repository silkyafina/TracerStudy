<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
{
    
    $admin = Auth::guard('admin')->user();

    // kalau belum login → redirect
    if (!$admin) {
        return redirect()->route('admin.login');
    }
    
    if (!in_array($admin->role, $roles)) {
        abort(403, 'Akses ditolak');
    }

    return $next($request);
    
}
}