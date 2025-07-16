<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthController;
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
    Route::get('/{id}', [CountryController::class, 'find']);
    Route::post('/', [CountryController::class, 'create']);
    Route::put('/{id}', [CountryController::class, 'updateById']);
    Route::delete('/{id}', [CountryController::class, 'deleteById']);
    Route::get('/list',[CountryController::class,'list']);
});

Route::prefix('dictis')->group(function () {
    Route::get('/', [DictiController::class, 'all']);
    Route::get('/{id}', [DictiController::class, 'find']);
    Route::post('/', [DictiController::class, 'create']);
    Route::put('/{id}', [DictiController::class, 'updateById']);
    Route::delete('/{id}', [DictiController::class, 'deleteById']);
    Route::get('/list',[DictiController::class,'list']);
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

Route::post('/webhook', [TelegramWebhookController::class,"webhook"]);

Route::prefix('role')->group(function () {
    Route::get('/', [RoleController::class, 'all']);
    Route::get('/{id}', [RoleController::class, 'find']);
    Route::post('/', [RoleController::class, 'create']);
    Route::put('/{id}', [RoleController::class, 'updateById']);
    Route::delete('/{id}', [RoleController::class, 'deleteById']);
    Route::get('/list',[RoleController::class,'list']);
});