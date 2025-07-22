<?php

namespace App\Http\Helpers;

use App\Mail\TwoFaMail;
use App\Models\TwoFactorToken;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Mail;

class VerifiedHelper
{
    public static function checkVerifed($user, $data)
    {
        if (!isset($user->last_verifed) || Carbon::parse($user->last_verifed)->lt(now()->subWeek())) {
            $model = TwoFactorToken::create([
                "email" => $user->email,
                "data" => json_encode($data)
            ]);

            Mail::to($model->email)->send(new TwoFaMail($model->two_factor_code));
            throw new HttpResponseException(
                response()->json([
                    "success" => false,
                    "message" => "We sent a verification email. Please enter the code.",
                    "uuid" => $model->uuid
                ], 200)
            );
        }
    }
}
