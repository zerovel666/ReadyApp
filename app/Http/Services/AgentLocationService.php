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

    public function updateOrCreate($data)
    {
        $attributes = [
            "agent_id" => $data['agent_id']
        ];
        return $this->repository->updateOrCreate($attributes,$data);
    }
}