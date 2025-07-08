<?php

namespace App\Http\Repository;

use App\Models\Partner;

class PartnerRepository extends BaseRepository
{
    public function __construct(Partner $partner) {
        parent::__construct($partner);
    }

}