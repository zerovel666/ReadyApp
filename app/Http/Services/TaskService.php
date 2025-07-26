<?php

namespace App\Http\Services;

use App\Http\Repository\TaskRepository;

class TaskService extends BaseService
{
    public function __construct(TaskRepository $taskRepository) {
        parent::__construct($taskRepository);
    }
}