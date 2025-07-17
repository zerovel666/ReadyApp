<?php

namespace App\Http\Services;

use App\Http\Repository\CarImageRepository;

class CarImageService extends BaseService
{
    public function __construct(CarImageRepository $carImageRepository) {
        parent::__construct($carImageRepository);
    }
}