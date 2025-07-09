<?php

namespace App\Http\Services;

use App\Http\Repository\CountryRepository;

class CountryService extends BaseService
{
    public function __construct(CountryRepository $countryRepository) {
        parent::__construct($countryRepository);
        $this->repository = $countryRepository;
    }

    public function list()
    {
        return $this->repository->getWithChildren();
    }
}