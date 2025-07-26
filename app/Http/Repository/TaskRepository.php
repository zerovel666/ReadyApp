<?php

namespace App\Http\Repository;

use App\Models\Task;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $task) {
        parent::__construct($task);
    }
}