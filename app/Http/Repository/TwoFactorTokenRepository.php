<?php

namespace App\Http\Repository;

use App\Models\TwoFactorToken;

class TwoFactorTokenRepository extends BaseRepository
{
    public function __construct(TwoFactorToken $twoFactorToken) {
        parent::__construct($twoFactorToken);
    }

    public function findByUuid($uuid)
    {
        return $this->model->where("uuid",$uuid)->first();
    }
}