<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::user() || !Auth::user()->hasRole($role)) {
            return response()->json(['error' => 'Not authorized.'],401);
        }

        return $next($request);
    }
}
