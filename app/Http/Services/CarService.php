<?php

namespace App\Http\Services;

use App\Http\Repository\CarModelRepository;
use App\Http\Repository\CarRepository;

class CarService extends BaseService
{
    public $carModelRepository;
    public function __construct(CarRepository $carRepository, CarModelRepository $carModelRepository)
    {
        parent::__construct($carRepository);
        $this->carModelRepository = $carModelRepository;
    }

    public function create($data)
    {
        if ($data['acitve']) {
            if (!$this->carModelRepository->find($data['model_id'])?->active) {
                throw new \Exception("You cannot create available cars if the car brand is inactive");
            }
        }

        return $this->repository->create($data);
    }
}
