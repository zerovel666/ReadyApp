<?php

use App\Http\Controllers\AgentController;
use App\Http\Helpers\Response;
use Illuminate\Support\Facades\Route;


Route::get("/health",function () {
    $data = [
        "request" => "health",
        "time" => time()
    ];
    return Response::response($data);
});

Route::get('/agent/health',[AgentController::class,'health']);