<?php

namespace App\Http\Repository;

use App\Models\AgentInfo;

class AgentInfoRepository extends BaseRepository
{
    public function __construct(AgentInfo $agentInfo) {
        parent::__construct($agentInfo);
    }
}