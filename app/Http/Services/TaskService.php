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

    public function updateById($id, $attributes)
    {
        $checkListItem = $this->repository->find($id);
        if (!$checkListItem){
            throw new \Exception("Object form item task with id $id not found",404);
        }

        $task = $checkListItem->task;
        if ($task->status->constant !== "IN_WORK"){
            throw new \Exception("You cannot edit the form while the task is not in progress.",422);
        }

        return $this->repository->updateById($id,$attributes);
    }
}