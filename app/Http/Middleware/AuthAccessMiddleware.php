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
        $data = $request->all();
        $token = Str::after($request->header('Authorization'), 'Bearer');
        $chatId = $data['message']['chat']['id'] ?? null;

        $implArr = [
            'chat' => fn() => $this->telegramImplement($chatId),
            'web' => fn() => $this->webImplement($token),
        ];

        if ($chatId) {
            $user = $implArr['chat']();
        } elseif ($token) {
            $user = $implArr['web']();
        } else {
            throw new \Exception("Unauthorized", 401);
        }

        Auth::login($user);
        return $next($request);
    }


    public function telegramImplement($chatId)
    {
        $user = User::where("telegram_chat_id", $chatId)->first();
        if (!$user) {
            throw new \Exception("Unauthorization", 401);
        }

        return $user;
    }

    public function webImplement($token)
    {
        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken) {
            throw new \Exception("Unauthorization", 401);
        }
        $user = $accessToken->tokenable;

        return $user;
    }
}
