<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Response;
use App\Http\Resource\AgentInfoResource;
use App\Http\Resource\UserResource;
use App\Http\Services\AgentInfoService;
use Illuminate\Http\Request;

class AgentInfoController extends Controller
{
    public $agentInfoService;

    public function __construct(AgentInfoService $agentInfoService) {
        $this->agentInfoService = $agentInfoService;
    }

    public function getMeInfo()
    {
        return Response::response(new UserResource($this->agentInfoService->getMeInfo()));
    }

    public function all()
    {
        return Response::response(AgentInfoResource::collection($this->agentInfoService->all()));
    }

        public function updateById($id, Request $request)
    {
        return Response::response(new AgentInfoResource($this->agentInfoService->updateById($id, $request->all())));
    }
    public function deleteById($id)
    {
        return Response::response($this->agentInfoService->deleteById($id));
    }
    public function create(Request $request)
    {
        return Response::response(new AgentInfoResource($this->agentInfoService->create($request->all())));
    }

    public function getKPI()
    {
        return Response::response($this->agentInfoService->getKPI());
    }
}
