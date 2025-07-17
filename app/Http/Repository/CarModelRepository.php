<?php

namespace App\Http\Repository;

use App\Models\CarModel;

class CarModelRepository extends BaseRepository
{
    public function __construct(CarModel $carModel) {
        parent::__construct($carModel);
    }
}