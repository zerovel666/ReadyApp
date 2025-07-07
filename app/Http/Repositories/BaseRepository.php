<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository 
{
    public Model $model;

    public function __construct(Model $model) {
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

    public function getByColumn($column,$attribute)
    {
        return $this->model->where($column,$attribute)->get();
    }

    public function updateByColumn($column,$value,$attributes)
    {
        return $this->model->where($column,$value)->update($attributes);
    }

    public function deleteById($id)
    {
        return $this->model->destroy($id);
    }
}