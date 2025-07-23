<?php

namespace App\Http\Services;

use App\Http\Repository\AgentInfoRepository;

class AgentInfoService extends BaseService
{
    public function __construct(AgentInfoRepository $agentInfoRepository) {
        parent::__construct($agentInfoRepository);
    }
    
}