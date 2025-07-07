<?php

namespace App\Http\Services;

use App\Http\Repository\BaseRepository;

class BaseService
{
    public $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }
    public function getByColumn($column, $attribute)
    {
        return $this->repository->getByColumn($column, $attribute);
    }
    public function updateById($id, $attributes)
    {
        $model = $this->repository->updateById($id, $attributes);
        if ($model) {
            return [
                "message" => "Success update"
            ];
        }
        return [
            "message" => "Nothing update"
        ];
    }
    public function deleteById($id)
    {
        $model = $this->repository->deleteById($id);
        if ($model) {
            return [
                "message" => "Success delete"
            ];
        }
        return [
            "message" => "Nothing delete"
        ];
    }
    public function create($data)
    {
        return $this->repository->create($data);
    }
}
