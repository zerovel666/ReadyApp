<?php

namespace App\Http\Services;

use App\Http\Repository\DictiRepository;

class DictiService extends BaseService
{
    public function __construct(DictiRepository $dictiRepository) {
        parent::__construct($dictiRepository);
    }
}