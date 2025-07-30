<?php

namespace App\Http\Repository;

use App\Models\CheckList;

class CheckListRepository extends BaseRepository
{
    public function __construct(CheckList $checkList) {
        parent::__construct($checkList);
    }
}