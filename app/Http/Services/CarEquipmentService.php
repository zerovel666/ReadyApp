<?php

namespace App\Http\Services;

use App\Http\Repository\CarEquipmentRepository;
use App\Http\Resource\CarResource;

use function PHPUnit\Framework\isEmpty;

class CarEquipmentService extends BaseService
{
    public function __construct(CarEquipmentRepository $carEquipmentRepository)
    {
        parent::__construct($carEquipmentRepository);
    }

    public function getByFilter($attributes)
    {
        return $this->repository->getByFilter($attributes);
    }

    public function dashboard()
    {
        $carEquipments = $this->repository
            ->getByColumn("active", true)
            ->load('cars', 'cars.status');

        $cars = $carEquipments
            ->flatMap->cars
            ->map(function ($car) {
                return new CarResource($car);
            })
            ->groupBy(function ($carResource) {
                return $carResource->status->full_name;
            });

        return $cars;
    }
}
