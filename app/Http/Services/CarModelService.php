<?php

namespace App\Http\Services;

use App\Http\Repository\CarModelRepository;

class CarModelService extends BaseService
{
    public function __construct(CarModelRepository $carModelRepository) {
        parent::__construct($carModelRepository);
    }

}