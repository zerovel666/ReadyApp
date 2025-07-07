<?php

namespace App\Http\Helpers;

use Throwable;

class ExceptionHelper
{
    public static function renderException(Throwable $e): \Illuminate\Http\JsonResponse
    {
        $trace = $e->getTrace();

        $response = [
            "data" => [
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
                "class" => $trace[0]['class'] ?? null,
                "function" => $trace[0]['function'] ?? null,
                "service" => config('app.name'),
            ],
            "status" => false,
        ];

        $code = ($e->getCode() >= 100 && $e->getCode() <= 599) ? $e->getCode() : 500;
        self::logError($e);
        return response()->json($response, $code);
    }

    public static function logError(Throwable $e): void
    {
        \Log::error("Exception caught", [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'service' => config('app.name')
        ]);
    }
}
