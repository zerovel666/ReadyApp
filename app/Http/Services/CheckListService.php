<?php

namespace App\Http\Services;

use App\Http\Repository\CheckListRepository;

class CheckListService extends BaseService
{
    public function __construct(CheckListRepository $checkListRepository)
    {
        parent::__construct($checkListRepository);
    }

    public function updateById($id, $attributes)
    {
        $checkListItem = $this->repository->find($id);

        $task = $checkListItem->task;
        if ($task->status->constant !== "IN_WORK") {
            throw new \Exception("You cannot edit the form while the task is not in progress.", 422);
        }

        return $this->repository->updateById($id, $attributes);
    }
}
