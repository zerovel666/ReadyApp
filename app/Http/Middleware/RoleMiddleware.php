<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception("Unauthorized",401);
        }

        $roles = $user->roles()->pluck('slug')->toArray();
        if (in_array("admin",$roles)){
            return $next($request);
        }

        if (!in_array($role, $roles)) {
            throw new \Exception("Forbidden",403);
        }

        return $next($request);
    }
}
