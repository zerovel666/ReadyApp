<?php

namespace App\Http\Repository;

use App\Models\TwoFactorToken;

class TwoFactorTokenRepository extends BaseRepository
{
    public function __construct(TwoFactorToken $twoFactorToken) {
        parent::__construct($twoFactorToken);
    }

    public function findToken($telegram_user_id,$two_factor_code)
    {
        return $this->model->where("telegram_user_id",$telegram_user_id)->where("two_factor_code",$two_factor_code)->first();
    }
}