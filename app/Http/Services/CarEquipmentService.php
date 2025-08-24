<?php

namespace App\Http\Services;

use App\Http\Repository\CarEquipmentRepository;

class CarEquipmentService extends BaseService
{
    public function __construct(CarEquipmentRepository $carEquipmentRepository) {
        parent::__construct($carEquipmentRepository);
    }

    public function getByFilter($attributes)
    {
        return $this->repository->getByFilter($attributes);
    }
}