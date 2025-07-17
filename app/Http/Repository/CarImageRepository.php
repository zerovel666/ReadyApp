<?php

namespace App\Http\Repository;

use App\Models\CarImage;

class CarImageRepository extends BaseRepository
{
    public function __construct(CarImage $carImage) {
        parent::__construct($carImage);
    }
}