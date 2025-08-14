<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $token = $request->bearerToken();       
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken && Carbon::parse($accessToken->expires_at)->isPast()){
            throw new \Exception("Access token expired",422);
        }
        Auth::login($accessToken->tokenable);
        return $next($request);
    }

}
