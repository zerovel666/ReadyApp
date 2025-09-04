<?php

namespace App\Http\Services;

use App\Http\Repository\PromoCodeRepository;

class PromoCodeService extends BaseService
{
    public function __construct(PromoCodeRepository $promoCodeRepository) {
        parent::__construct($promoCodeRepository);
    }
}