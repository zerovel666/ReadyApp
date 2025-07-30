<?php

namespace App\Http\Services;

use App\Http\Repository\CheckListRepository;

class CheckListService extends BaseService
{
    public function __construct(CheckListRepository $checkListRepository) {
        parent::__construct($checkListRepository);
    }
}