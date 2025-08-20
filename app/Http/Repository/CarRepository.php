<?php

namespace App\Http\Repository;

use App\Models\Car;

class CarRepository extends BaseRepository
{
    public function __construct(Car $car)
    {
        parent::__construct($car);
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
