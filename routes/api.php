<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentInfoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarImageController;
use App\Http\Controllers\CarLocationController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DictiController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TelegramWebhookController;
use App\Http\Controllers\UserController;
use App\Http\Helpers\Response;
use App\Http\Middleware\AuthAccessMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


Route::get("/health", function () {
    $data = [
        "request" => "health",
        "time" => time()
    ];
    return Response::response($data);
});

Route::prefix('agent')->group(function () {
    Route::get('/health', [AgentController::class, 'health']);
});

Route::prefix('country')->group(function () {
    Route::get('/', [CountryController::class, 'all']);
    Route::get('/list', [CountryController::class, 'list']);
    Route::get('/{id}', [CountryController::class, 'find']);
    Route::post('/', [CountryController::class, 'create']);
    Route::put('/{id}', [CountryController::class, 'updateById']);
    Route::delete('/{id}', [CountryController::class, 'deleteById']);
});

Route::prefix('dictis')->group(function () {
    Route::get('/', [DictiController::class, 'all']);
    Route::get('/list', [DictiController::class, 'list']);
    Route::get('/{id}', [DictiController::class, 'find']);
    Route::post('/', [DictiController::class, 'create']);
    Route::put('/{id}', [DictiController::class, 'updateById']);
    Route::delete('/{id}', [DictiController::class, 'deleteById']);
});

Route::prefix('partner')->group(function () {
    Route::get('/', [PartnerController::class, 'all']);
    Route::get('/{id}', [PartnerController::class, 'find']);
    Route::post('/', [PartnerController::class, 'create']);
    Route::put('/{id}', [PartnerController::class, 'updateById']);
    Route::delete('/{id}', [PartnerController::class, 'deleteById']);
    Route::post("/upload/{id}", [PartnerController::class, 'upload']);
});

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('confirm', [AuthController::class, 'confirmTwoFactor']);
});

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'all']);
    Route::get('/{id}', [UserController::class, 'find']);
    Route::delete('/{id}', [UserController::class, 'deleteById']);
    Route::put('/{id}', [UserController::class, 'updateById']);
});

Route::post('/webhook', [TelegramWebhookController::class, "webhook"]);

Route::prefix('role')->group(function () {
    Route::get('/', [RoleController::class, 'all']);
    Route::get('/{id}', [RoleController::class, 'find']);
    Route::post('/', [RoleController::class, 'create']);
    Route::put('/{id}', [RoleController::class, 'updateById']);
    Route::delete('/{id}', [RoleController::class, 'deleteById']);
});

Route::prefix('car/model')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::get('/', [CarModelController::class, 'all']);
    Route::get('/{id}', [CarModelController::class, 'find']);
    Route::post('/', [CarModelController::class, 'create']);
    Route::put('/{id}', [CarModelController::class, 'updateById']);
    Route::delete('/{id}', [CarModelController::class, 'deleteById']);
});

Route::prefix('car/image')->group(function () {
    Route::get('/', [CarImageController::class, 'all']);
    Route::get('/{id}', [CarImageController::class, 'find']);
    Route::post('/', [CarImageController::class, 'create']);
    Route::put('/{id}', [CarImageController::class, 'updateById']);
    Route::delete('/{id}', [CarImageController::class, 'deleteById']);
});

Route::prefix('car/location')->group(function () {
    Route::get('/', [CarLocationController::class, 'all']);
    Route::get('/{id}', [CarLocationController::class, 'find']);
    Route::post('/', [CarLocationController::class, 'create']);
    Route::put('/{id}', [CarLocationController::class, 'updateById']);
    Route::delete('/{id}', [CarLocationController::class, 'deleteById']);
});

Route::prefix('car')->group(function () {
    Route::get('/', [CarController::class, 'all']);
    Route::get('/{id}', [CarController::class, 'find']);
    Route::post('/', [CarController::class, 'create']);
    Route::put('/{id}', [CarController::class, 'updateById']);
    Route::delete('/{id}', [CarController::class, 'deleteById']);
});

Route::prefix('booking')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::get('/', [BookingController::class, 'allMeByStatus']);
    Route::post('/', [BookingController::class, 'create']);
    Route::delete('/{id}', [BookingController::class, 'cancel']);
});

Route::prefix('agent')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::prefix('info')->group(function () {
        Route::get('/me', [AgentInfoController::class, 'getMeInfo']);
        Route::get('/', [AgentInfoController::class, 'all']);
        Route::get('/{user_id}', [AgentInfoController::class, 'find']);
        Route::post('/{user_id}', [AgentInfoController::class, 'create']);
        Route::put('/{user_id}', [AgentInfoController::class, 'updateById']);
        Route::delete('/{user_id}', [AgentInfoController::class, 'deleteById']);
    });
});
