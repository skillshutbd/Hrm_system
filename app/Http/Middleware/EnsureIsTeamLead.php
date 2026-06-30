<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsTeamLead
{
    public function handle(Request $request, Closure $next)
    {
        if (auth('employee')->check() && auth('employee')->user()->role === 'team_lead') {
            return $next($request);
        }

        abort(403, 'Unauthorized. Team Lead access only.');
    }
}