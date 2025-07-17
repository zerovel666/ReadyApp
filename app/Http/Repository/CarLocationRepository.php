<?php

namespace App\Http\Repository;

use App\Models\CarLocation;

class CarLocationRepository extends BaseRepository
{
    public function __construct(CarLocation $carLocation) {
        parent::__construct($carLocation);
    }
}