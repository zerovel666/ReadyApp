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
        $model = $this->repository->getByColumn($column, $attribute);
        if ($model->isEmpty()){
            throw new \Exception("Object where $column = $attribute not found",404);
        }
        return $model;
    }

    public function updateById($id, $attributes)
    {
        return $this->repository->updateById($id, $attributes);
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

    public function paginate()
    {
        return $this->repository->paginate();
    }
}
