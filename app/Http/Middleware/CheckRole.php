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
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = array_slice(func_get_args(), 2);

        if (!Auth::user()) {
            return response()->json(['message' => 'Вы не авторизованы.'],401);
        }

        foreach (Auth::user()->roles as $role) {
            if (in_array(mb_strtolower($role->name), $roles)) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'У вас недостаточно прав для доступа к данной странице.'],403);
    }
}
