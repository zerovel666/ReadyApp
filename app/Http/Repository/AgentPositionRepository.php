<?php

namespace App\Http\Repository;

use App\Models\AgentPosition;

class AgentPositionRepository extends BaseRepository
{
    public function __construct(AgentPosition $agentPosition) {
        parent::__construct($agentPosition);
    }
}