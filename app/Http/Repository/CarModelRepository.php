<?php

namespace App\Http\Repository;

use App\Models\Car;
use App\Models\CarModel;

class CarModelRepository extends BaseRepository
{
    public function __construct(CarModel $carModel)
    {
        parent::__construct($carModel);
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

        $query = $this->setFilterByCar($attributes, $query);

        return $query->get();
    }

    public function setFilterByCar($attributes, $query)
    {
        $fieldsRelationCar = (new Car())->getFillable();

        foreach ($fieldsRelationCar as $field) {
            if (isset($attributes[$field])) {
                $query->whereHas("cars", function ($q) use ($field, $attributes) {
                    $q->where($field, $attributes[$field]);
                });
            }
        }

        return $query;
    }

    public function getWithDiscount()
    {
        return $this->model->whereHas('discount')->with('discount')->get();
    }
}
