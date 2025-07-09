<?php

namespace App\Http\Repository;

use App\Models\Country;

class CountryRepository extends BaseRepository
{
    public function __construct(Country $country)
    {
        parent::__construct($country);
    }

    public function getWithChildren($countries = null)
    {
        if (is_null($countries)) {
            $countries = $this->model->whereNull('parent_countries_id')->get();
        }

        return $countries->map(function ($country) {
            $children = $this->getWithChildren($country->children);
            $country->setRelation('children', $children);
            return $country;
        });
    }
}
