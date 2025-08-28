<?php

namespace App\Http\Repository;

use App\Models\Task;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    public function getByFilter($attributes)
    {
        $query = $this->model->newQuery();

        $fields = $this->model->getFillable();

        foreach ($fields as $field) {
            if (isset($attributes[$field])) {
                $query->where($field, $attributes[$field]);
            }
        }

        return $query->get();
    }
}
