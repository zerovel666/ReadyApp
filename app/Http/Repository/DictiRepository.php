<?php

namespace App\Http\Repository;

use App\Models\Dicti;

class DictiRepository extends BaseRepository
{
    public function __construct(Dicti $dicti) {
        parent::__construct($dicti);
    }
}