<?php

namespace App\Http\Repository;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function getByColumn($column, $attribute)
    {
        return $this->model->where($column, $attribute)->get();
    }

    public function updateById($id, $attributes)
    {
        return $this->model->where("id", $id)->update($attributes);
    }

    public function deleteById($id)
    {
        $model = $this->model->find($id);
        if (!$model) {
            throw new \Exception("Object with id $id not found", 404);
        }
        return $model->delete($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function updateByColumn($column, $value, $attributes)
    {
        $model = $this->model->where($column, $value)->first();
        if (!$model) {
            throw new \Exception("Object with $column => $value not found", 404);
        }
        return $model->update($attributes);
    }
}
