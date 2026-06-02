<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrHr
{
    public function handle(Request $request, Closure $next)
    {
        $adminUser = $request->user();
        $hrUser = auth('Hr')->user();

        if ($adminUser && method_exists($adminUser, 'hasRole') && $adminUser->hasRole('Admin')) {
            return $next($request);
        }

        if ($hrUser && $hrUser->role === 'hr_admin') {
            return $next($request);
        }

        abort(403);
    }
}