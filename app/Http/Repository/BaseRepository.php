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
        $model = $this->model->find($id);
        if (!$model) {
            throw new \Exception("Object with id $id not found", 404);
        }
        return $model;
    }

    public function getByColumn($column, $attribute)
    {
        return $this->model->where($column, $attribute)->get();
    }

    public function firstByColumn($column, $attribute)
    {
        return $this->model->where($column, $attribute)->first();
    }

    public function getByMultipieColumns($keyValArr)
    {
        $model = $this->model;
        foreach ($keyValArr as $key => $value){
            $model->where($key,$value);
        }
        return $model->get();
    }

    public function updateById($id, $attributes)
    {   
        $model = $this->model->find($id);
        $model->update($attributes);
        return $model;
    }

    public function deleteById($id)
    {
        return $this->model->where("id", $id)->delete();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function updateByColumn($column, $value, $attributes)
    {
        return $this->model->where($column, $value)->update($attributes);
    }

    public function paginate()
    {
        return $this->model->paginate(20);
    }

    public function updateOrCreate($attributes,$values)
    {
        return $this->model->updateOrCreate($attributes,$values);
    }
}
