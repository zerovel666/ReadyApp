<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Services\AgentPositionService;
use Illuminate\Http\Request;

class AgentPositionController extends Controller
{
    public $agentPositionService;

    public function __construct(AgentPositionService $agentPositionService) {
        $this->agentPositionService = $agentPositionService;
    }

    public function findByUserId($id)
    {
        return Response::response($this->agentPositionService->findByUserId($id));
    }

    public function updateOrCreate(Request $request)
    {
        return Response::response($this->agentPositionService->updateOrCreate($request->all()));
    }
}
