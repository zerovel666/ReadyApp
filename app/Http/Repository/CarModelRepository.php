<?php

namespace App\Http\Repository;

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

        $fields = [
            'brand_id',
            'name',
            'stamp_id',
            'body_id',
            'engine_id',
            'transmission_id',
            'engine_volume',
            'power',
            'seats',
            'doors',
            'fuel_tank_capacity',
            'weight',
            'height',
            'active',
        ];

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
        $fieldsRelationCar = [
            "model_id",
            "partner_id",
            "vin",
            "license_plate",
            "color_id",
            "mileage",
            "last_inspection_date",
            "date_release",
            "rating",
            "status",
            "amount",
            "currency_id"
        ];

        foreach ($fieldsRelationCar as $field) {
            if (isset($attributes[$field])) {
                $query->whereHas("cars", function ($q) use ($field, $attributes) {
                    $q->where($field, $attributes[$field]);
                });
            }
        }

        return $query;
    }
}
