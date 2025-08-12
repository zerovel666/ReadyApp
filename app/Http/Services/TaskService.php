<?php

namespace App\Http\Services;

use App\Http\Repository\DictiRepository;
use App\Http\Repository\TaskRepository;
use Illuminate\Support\Facades\Auth;

class TaskService extends BaseService
{
    public $dictiRepository;
    public function __construct(TaskRepository $taskRepository)
    {
        $this->dictiRepository = app(DictiRepository::class);
        parent::__construct($taskRepository);
    }

    public function all()
    {
        $user = Auth::user();
        $agent_id = $user->agent->id;
        return $this->repository->getByColumn("agent_id", $agent_id);
    }

    public function updateById($id, $attributes)
    {
        $model = $this->repository->find($id);
        if (isset($attributes['status_id']) && !is_null($attributes['status_id'])) {
            $dicti = $this->dictiRepository->firstByColumn("id", $attributes['status_id']);
            if ($dicti->constant == "COMPLETED") {
                $checkList = $model->checkList;
                $damagedItemCheckList = $checkList->where("damaged", true)->first();
                $noCheck = $checkList->where("checking",false)->first();
                if ($noCheck){
                    throw new \Exception("Please check all list.",400);
                }
                if ($damagedItemCheckList && !$damagedItemCheckList->damage) {
                    throw new \Exception("Please attach the damage to the task before closing the task.",400);
                }
            }
        }
        $model->update($attributes);
        return $model;
    }
}
