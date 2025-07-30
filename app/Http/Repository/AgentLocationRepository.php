<?php

namespace App\Http\Repository;

use App\Models\AgentLocation;

class AgentLocationRepository extends BaseRepository
{
    public function __construct(AgentLocation $AgentLocation) {
        parent::__construct($AgentLocation);
    }
}