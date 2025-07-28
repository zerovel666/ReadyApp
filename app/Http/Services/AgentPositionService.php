<?php

namespace App\Http\Services;

use App\Http\Repository\AgentPositionRepository;
use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;

class AgentPositionService extends BaseService
{
    public $userRepository;
    public function __construct(AgentPositionRepository $agentPositionRepository, UserRepository $userRepository) {
        parent::__construct($agentPositionRepository);
        $this->userRepository = $userRepository;
    }

    public function findByUserId($id)
    {
        $user = $this->userRepository->find($id);
        return $user->agent->position;
    }

    public function updateOrCreate($attributes)
    {
        $user = Auth::user()->agent;
        return $this->repository->updateOrCreate($user->id,$attributes);
    }
}