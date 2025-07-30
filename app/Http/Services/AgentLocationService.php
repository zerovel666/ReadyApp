<?php

namespace App\Http\Services;

use App\Http\Repository\AgentLocationRepository;
use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;

class AgentLocationService extends BaseService
{
    public $userRepository;
    public function __construct(AgentLocationRepository $AgentLocationRepository, UserRepository $userRepository) {
        parent::__construct($AgentLocationRepository);
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