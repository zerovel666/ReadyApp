<?php

namespace App\Http\Repository;

use App\Models\DamageImage;

class DamageImageRepository extends BaseRepository
{
    public function __construct(DamageImage $damageImage) {
        parent::__construct($damageImage);
    }
}