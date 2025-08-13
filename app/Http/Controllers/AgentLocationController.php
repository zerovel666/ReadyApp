<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Services\AgentLocationService;
use Illuminate\Http\Request;

class AgentLocationController extends Controller
{
    public $agentLocationService;

    public function __construct(AgentLocationService $agentLocationService) {
        $this->agentLocationService = $agentLocationService;
    }

    public function findByAgentId($id)
    {
        return Response::response($this->agentLocationService->getByColumn("agent_id",$id));
    }

    public function updateOrCreate(Request $request)
    {
        return Response::response($this->agentLocationService->updateOrCreate($request->all()));
    }
}
