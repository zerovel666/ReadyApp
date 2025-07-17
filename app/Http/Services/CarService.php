<?php

namespace App\Http\Services;

use App\Http\Repository\CarRepository;

class CarService extends BaseService
{
    public function __construct(CarRepository $carRepository)
    {
        parent::__construct($carRepository);
    }

    public function list()
    {
        return $this->repository->getWithChildren();
    }
}
