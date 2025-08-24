<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentInfoController;
use App\Http\Controllers\AgentLocationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarEquipmentController;
use App\Http\Controllers\CarImageController;
use App\Http\Controllers\CarLocationController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DamageImageController;
use App\Http\Controllers\DamageNoteController;
use App\Http\Controllers\DictiController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TelegramWebhookController;
use App\Http\Controllers\UserController;
use App\Http\Helpers\Response;
use App\Http\Middleware\AuthAccessMiddleware;
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

Route::prefix('country')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::get('/', [CountryController::class, 'all']);
    Route::get('/list', [CountryController::class, 'list']);
    Route::get('/{id}', [CountryController::class, 'find']);
    Route::post('/', [CountryController::class, 'create']);
    Route::put('/{id}', [CountryController::class, 'updateById']);
    Route::delete('/{id}', [CountryController::class, 'deleteById']);
});

Route::prefix('dictis')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::get('/constant', [DictiController::class, 'getByConstant']);
    Route::get('/', [DictiController::class, 'all']);
    Route::get('/list', [DictiController::class, 'list']);
    Route::get('/{id}', [DictiController::class, 'find']);
    Route::post('/', [DictiController::class, 'create']);
    Route::put('/{id}', [DictiController::class, 'updateById']);
    Route::delete('/{id}', [DictiController::class, 'deleteById']);
});

Route::prefix('partner')->middleware(AuthAccessMiddleware::class)->group(function () {
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
    Route::post('token/refresh', [AuthController::class, 'refreshAuthToken']);
    // Route::post('confirm', [AuthController::class, 'confirmTwoFactor']);
});

Route::prefix('user')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::prefix('role')->group(function () {
        Route::post('/', [UserController::class, 'attachRole']);
        Route::delete('/', [UserController::class, 'destroyUserRole']);
    });
    Route::get('/', [UserController::class, 'all']);
    Route::get('/{id}', [UserController::class, 'find']);
    Route::delete('/{id}', [UserController::class, 'deleteById']);
    Route::put('/{id}', [UserController::class, 'updateById']);
    Route::post('/', [UserController::class, 'create']);
});

Route::post('/webhook', [TelegramWebhookController::class, "webhook"]);

Route::prefix('role')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::get('/', [RoleController::class, 'all']);
    Route::get('/{id}', [RoleController::class, 'find']);
    Route::post('/', [RoleController::class, 'create']);
    Route::put('/{id}', [RoleController::class, 'updateById']);
    Route::delete('/{id}', [RoleController::class, 'deleteById']);
});

Route::prefix('car/model')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::get('/brand/{id}', [CarModelController::class, 'getModelByBrandId']);
    Route::get('/brands', [DictiController::class, 'getBrands']);
    Route::get('/filter', [CarModelController::class, 'getByFilter']);
    Route::get('/', [CarModelController::class, 'all']);
    Route::get('/{id}', [CarModelController::class, 'find']);
    Route::post('/', [CarModelController::class, 'create']);
    Route::put('/{id}', [CarModelController::class, 'updateById']);
    Route::delete('/{id}', [CarModelController::class, 'deleteById']);
    Route::prefix('equipment')->middleware(AuthAccessMiddleware::class)->group(function () {
        Route::get('/filter', [CarEquipmentController::class, 'getByFilter']);
        Route::get('/', [CarEquipmentController::class, 'all']);
        Route::get('/{id}', [CarEquipmentController::class, 'find']);
        Route::delete('/{id}', [CarEquipmentController::class, 'deleteById']);
        Route::put('/{id}', [CarEquipmentController::class, 'updateById']);
        Route::post('/', [CarEquipmentController::class, 'create']);
    });
});

Route::prefix('car/image')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::get('/{car_equipment_id}', [CarImageController::class, 'getByCarModelId']);
    Route::post('/', [CarImageController::class, 'create']);
    Route::delete('/', [CarImageController::class, 'deleteById']);
});

Route::prefix('car/location')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::post('/', [CarLocationController::class, 'create']);
    Route::get('/{car_id}', [CarLocationController::class, 'getByCarId']);
});

Route::prefix('car')->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::get('/filter', [CarController::class, 'getByFilter']);
    Route::get('/', [CarController::class, 'all']);
    Route::get('/{id}', [CarController::class, 'find']);
    Route::post('/', [CarController::class, 'create']);
    Route::put('/{id}', [CarController::class, 'updateById']);
    Route::delete('/{id}', [CarController::class, 'deleteById']);
});

Route::prefix('booking')->middleware(AuthAccessMiddleware::class)->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::get('/', [BookingController::class, 'allMeByStatus']);
    Route::post('/{id}', [BookingController::class, 'paidTransacation']);
    Route::post('/', [BookingController::class, 'create']);
    Route::delete('/{id}', [BookingController::class, 'cancel']);
});

Route::prefix('agent')->middleware(AuthAccessMiddleware::class)->middleware(AuthAccessMiddleware::class)->group(function () {
    Route::prefix('info')->group(function () {
        Route::get('/me', [AgentInfoController::class, 'getMeInfo']);
        Route::get('/', [AgentInfoController::class, 'all']);
        Route::post('/', [AgentInfoController::class, 'create']);
        Route::put('/', [AgentInfoController::class, 'updateById']);
        Route::delete('/', [AgentInfoController::class, 'deleteById']);
    });

    Route::prefix('task')->middleware(AuthAccessMiddleware::class)->group(function () {
        Route::get('/', [TaskController::class, 'all']);
        Route::get('/{id}', [TaskController::class, 'find']);
        Route::post('/', [TaskController::class, 'create']);
        Route::put('/{id}', [TaskController::class, 'updateById']);
        Route::delete('/{id}', [TaskController::class, 'deleteById']);
        Route::prefix("checkList")->group(function () {
            Route::get('/{task_id}', [CheckListController::class, 'getByTaskId']);
            Route::put('/{id}', [CheckListController::class, 'update']);
        });
        Route::prefix("damage")->middleware(AuthAccessMiddleware::class)->group(function () {
            Route::post('/', [DamageNoteController::class, 'create']);
            Route::put('/{id}', [DamageNoteController::class, 'updateById']);
            Route::get('/active', [DamageNoteController::class, 'getActive']);
            Route::prefix('image')->group(function () {
                Route::post('/', [DamageImageController::class, 'create']);
                Route::get('/{damage_note_id}', [DamageImageController::class, 'allByDamageNoteId']);
                Route::delete('/{id}', [DamageImageController::class, 'deleteById']);
            });
        });
    });

    Route::prefix('location')->middleware(AuthAccessMiddleware::class)->group(function () {
        Route::get('/{id}', [AgentLocationController::class, 'findByAgentId']);
        Route::post('/', [AgentLocationController::class, 'updateOrCreate']);
    });
});
