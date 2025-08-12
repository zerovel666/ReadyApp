<?php

namespace App\Http\Services;

use App\Http\Repository\CarLocationRepository;

class CarLocationService extends BaseService
{
    public function __construct(CarLocationRepository $carLocationRepository) {
        parent::__construct($carLocationRepository);
    }

    public function create($data)
    {
        if ($model = $this->repository->firstByColumn("car_id",$data['car_id'])){
            $model->update($data);
            return $model;
        } else {
            return $this->repository->create($data);
        }
    }
}