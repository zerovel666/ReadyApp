<?php

namespace App\Http\Repository;

use App\Models\Discount;

class DiscountRepository extends BaseRepository
{
    public function __construct(Discount $discount) {
        parent::__construct($discount);
    }
}