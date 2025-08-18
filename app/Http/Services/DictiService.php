<?php

namespace App\Http\Services;

use App\Http\Repository\DictiRepository;

class DictiService extends BaseService
{
    public function __construct(DictiRepository $dictiRepository) {
        parent::__construct($dictiRepository);
    }

    public function list()
    {
        return $this->repository->getWithChildren();
    }

    public function getBrands()
    {
        return $this->repository->getChildrenByConstant("BRAND_CARS");
    }
}