<?php

use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use League\Uri\Exceptions\SyntaxError;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (RequestException $e) {
            $response = $e->getResponse();
            logError($e);
            if ($response) {
                $body = json_decode($response->getBody(), true);
                return response()->json($body, $response->getStatusCode());
            }

            return response()->json([
                "message" => "Внешний сервис недоступен",
                "status" => false
            ], 503);
        });
        $exceptions->render(function (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors(),
                'service' => config('app.name')
            ], 422);
        });

        $exceptions->render(fn(TypeError $e) => renderException($e));
        $exceptions->render(fn(SyntaxError $e) => renderException($e));
        $exceptions->render(fn(Exception $e) => renderException($e));
        $exceptions->render(fn(Throwable $e) => renderException($e));
    })->create();


function renderException(Throwable $e): \Illuminate\Http\JsonResponse
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
    logError($e);
    return response()->json($response, $code);
}

function logError(Throwable $e): void
{
    \Log::error("Exception caught", [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
        'service' => config('app.name')
    ]);
}
