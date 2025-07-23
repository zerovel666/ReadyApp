<?php

namespace App\Http\Services;

use App\Http\Repository\AgentInfoRepository;
use Illuminate\Support\Facades\Auth;

class AgentInfoService extends BaseService
{
    public function __construct(AgentInfoRepository $agentInfoRepository) {
        parent::__construct($agentInfoRepository);
    }
    
    public function getMeInfo()
    {
        $user = Auth::user();
        $user->agent;
        return $user;
    }
}