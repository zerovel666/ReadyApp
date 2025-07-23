<?php

namespace App\Http\Controllers;

use App\Http\Services\AgentInfoService;
use Illuminate\Http\Request;

class AgentInfoController extends Controller
{
    public $agentInfoService;

    public function __construct(AgentInfoService $agentInfoService) {
        $this->agentInfoService = $agentInfoService;
    }
}
