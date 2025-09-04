<?php

namespace App\Http\Repository;

use App\Models\PromoCode;

class PromoCodeRepository extends BaseRepository
{
    public function __construct(PromoCode $promoCode) {
        parent::__construct($promoCode);
    }
}