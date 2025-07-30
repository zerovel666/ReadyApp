<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Services\AgentLocationService;
use Illuminate\Http\Request;

class AgentLocationController extends Controller
{
    public $AgentLocationService;

    public function __construct(AgentLocationService $AgentLocationService) {
        $this->AgentLocationService = $AgentLocationService;
    }

    public function findByUserId($id)
    {
        return Response::response($this->AgentLocationService->findByUserId($id));
    }

    public function updateOrCreate(Request $request)
    {
        return Response::response($this->AgentLocationService->updateOrCreate($request->all()));
    }
}
