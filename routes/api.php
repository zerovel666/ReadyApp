<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PartnerController;
use App\Http\Helpers\Response;
use Illuminate\Support\Facades\Route;


Route::get("/health",function () {
    $data = [
        "request" => "health",
        "time" => time()
    ];
    return Response::response($data);
});

Route::prefix('agent')->group(function(){
    Route::get('/health',[AgentController::class,'health']);
});

Route::prefix('country')->group(function(){
    Route::get('/',[CountryController::class,'all']);
    Route::get('/{id}',[CountryController::class,'find']);
    Route::post('/',[CountryController::class,'create']);
    Route::put('/{id}',[CountryController::class,'updateById']);
    Route::delete('/{id}',[CountryController::class,'deleteById']);
});

Route::prefix('partner')->group(function(){
    Route::get('/',[PartnerController::class,'all']);
    Route::get('/{id}',[PartnerController::class,'find']);
    Route::post('/',[PartnerController::class,'create']);
    Route::put('/{id}',[PartnerController::class,'updateById']);
    Route::delete('/{id}',[PartnerController::class,'deleteById']);
    Route::post("/upload/{id}",[PartnerController::class,'upload']);
});