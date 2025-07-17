<?php

namespace App\Http\Repository;

use App\Models\Car;

class CarRepository extends BaseRepository
{
    public function __construct(Car $car) {
        parent::__construct($car);
    }
}