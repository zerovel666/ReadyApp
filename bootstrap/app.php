<?php

use App\Http\Helpers\ExceptionHelper;
use App\Http\Middleware\AuthAccessMiddleware;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\QueryException;
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
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (RequestException $e) {
            $response = $e->getResponse();
            ExceptionHelper::logError($e);
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

        $exceptions->render(fn(QueryException $e) => ExceptionHelper::renderException($e));
        $exceptions->render(fn(TypeError $e) => ExceptionHelper::renderException($e));
        $exceptions->render(fn(SyntaxError $e) => ExceptionHelper::renderException($e));
        $exceptions->render(fn(Exception $e) => ExceptionHelper::renderException($e));
        $exceptions->render(fn(Throwable $e) => ExceptionHelper::renderException($e));
    })->create();
