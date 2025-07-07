<?php

namespace App\Http\Services;

use App\Http\Repositories\BaseRepository;

class BaseService
{
    public $repository;

    public function __construct(BaseRepository $repository) {
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
    public function getByColumn($column,$attribute)
    {
        return $this->repository->getByColumn($column,$attribute);
    }
    public function updateByColumn($column,$value,$attributes)
    {
        return $this->repository->updateByColumn($column,$value,$attributes);
    }
    public function deleteById($id)
    {
        return $this->repository->deleteById($id);
    }
}