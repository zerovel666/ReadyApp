<?php

namespace App\Http\Services;

use App\Http\Repository\AgentInfoRepository;
use App\Http\Repository\DictiRepository;
use App\Http\Repository\RoleRepository;
use Illuminate\Support\Facades\Auth;

class AgentInfoService extends BaseService
{
    public $dictiRepository;
    public $roleRepository;
    public function __construct(AgentInfoRepository $agentInfoRepository,DictiRepository $dictiRepository,RoleRepository $roleRepository) {
        parent::__construct($agentInfoRepository);
        $this->dictiRepository = $dictiRepository;
        $this->roleRepository = $roleRepository;
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

    public function create($data)
    {
        $agent = $this->repository->create($data);
        $agent->user->roles()->attach($this->roleRepository->firstByColumn("slug",'agent')->id);
        return $agent;
    }
}