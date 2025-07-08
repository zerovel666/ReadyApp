<?php

namespace App\Http\Services;

use App\Http\Repository\CountryRepository;

class CountryService extends BaseService
{
    public function __construct(CountryRepository $countryRepository) {
        parent::__construct($countryRepository);
    }

    public function paginate()
    {
        return $this->repository->paginate();
    }
}