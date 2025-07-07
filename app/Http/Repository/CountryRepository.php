<?php

namespace App\Http\Repository;

use App\Models\Country;

class CountryRepository extends BaseRepository
{
    public function __construct(Country $country) {
        parent::__construct($country);
    }

}