<?php

namespace App\Http\Services;

use App\Http\Repository\AgentInfoRepository;
use App\Http\Repository\DictiRepository;
use Illuminate\Support\Facades\Auth;

class AgentInfoService extends BaseService
{
    public $dictiRepository;
    public function __construct(AgentInfoRepository $agentInfoRepository,DictiRepository $dictiRepository) {
        parent::__construct($agentInfoRepository);
        $this->dictiRepository = $dictiRepository;
    }
    
    public function getMeInfo()
    {
        $user = Auth::user();
        $user->agent;
        return $user;
    }

    public function getFreeAgent()
    {
        $statusParent = $this->dictiRepository->firstByColumn("constant","AGENT_STATUS");
        $children = $statusParent->children();
        $statusActive = $children->where('constant', 'ACTIVE')->first();
        $freeAgent = $this->repository->getByColumn("status_id",$statusActive->id);
        if ($freeAgent->isNotEmpty()){
            return $freeAgent->random();
        }

        return $this->repository->getWithFewTask();
    }
}