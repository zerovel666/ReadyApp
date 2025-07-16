<?php

namespace App\Http\Repository;

use App\Models\TwoFactorToken;

class TwoFactorTokenRepository extends BaseRepository
{
    public function __construct(TwoFactorToken $twoFactorToken)
    {
        parent::__construct($twoFactorToken);
    }

    public function findToken($telegram_chat_id, $two_factor_code)
    {
        return $this->model->where("telegram_chat_id", $telegram_chat_id)->where("two_factor_code", $two_factor_code)->first();
    }

    public function findTokenByUuid($uuid, $two_factor_code)
    {
        return $this->model->where("uuid", $uuid)->where("two_factor_code", $two_factor_code)->first();
    }
}
