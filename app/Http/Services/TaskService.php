<?php

namespace App\Http\Services;

use App\Http\Repository\TaskRepository;
use Illuminate\Support\Facades\Auth;

class TaskService extends BaseService
{
    public function __construct(TaskRepository $taskRepository) {
        parent::__construct($taskRepository);
    }

    public function all()
    {
        $user = Auth::user();
        $agent_id = $user->agent->id;
        return $this->repository->getByColumn("agent_id",$agent_id);
    }

}