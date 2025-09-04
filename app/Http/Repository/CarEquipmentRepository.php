<?php

namespace App\Http\Repository;

use App\Models\CarEquipment;

class CarEquipmentRepository extends BaseRepository
{
    public function __construct(CarEquipment $carEquipment)
    {
        parent::__construct($carEquipment);
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

    public function getWithDiscount()
    {
        return $this->model->whereHas('discount')->with('discount')->get();
    }
}
