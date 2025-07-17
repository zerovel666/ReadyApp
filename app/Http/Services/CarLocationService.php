<?php

namespace App\Http\Services;

use App\Http\Repository\CarLocationRepository;

class CarLocationService extends BaseService
{
    public function __construct(CarLocationRepository $carLocationRepository) {
        parent::__construct($carLocationRepository);
    }
}