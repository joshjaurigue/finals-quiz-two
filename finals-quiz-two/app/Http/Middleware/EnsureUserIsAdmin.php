<?php

namespace App\Http\Middleware;

use Closure;

class EnsureUserIsAdmin
{
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
