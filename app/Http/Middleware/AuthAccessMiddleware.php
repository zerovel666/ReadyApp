<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = Str::after($request->header('Authorization'), 'Bearer ');
        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);
            if (!$accessToken) {
                throw new \Exception("Unauthorization", 401);
            }
            $user = $accessToken->tokenable;
        } else {
            throw new \Exception("Unauthorization", 401);
        }
        Auth::login($user);
        return $next($request);
    }
}
