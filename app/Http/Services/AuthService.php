<?php

namespace App\Http\Services;

use App\Http\Helpers\Response;
use App\Http\Repository\DictiRepository;
use App\Http\Repository\TwoFactorTokenRepository;
use App\Http\Repository\UserRepository;
use App\Mail\TwoFaMail;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{
    public $userRepository;
    public $twoFactorRepository;
    public $dictiRepository;
    private $uuid = null;

    public function __construct(UserRepository $userRepository, TwoFactorTokenRepository $twoFactorTokenRepository, DictiRepository $dictiRepository)
    {
        $this->userRepository = $userRepository;
        $this->twoFactorRepository = $twoFactorTokenRepository;
        $this->dictiRepository = $dictiRepository;
    }

    public function register($attribute)
    {
        $type_auth = $attribute['type_auth_constant'];
        if (!$this->dictiRepository->checkTypeAuth($type_auth)) {
            throw new \Exception("Type auth not found", 422);
        }

        if ($this->userRepository->checkHasUser($attribute)) {
            throw new \Exception("A user with such an email is busy.", 400);
        }
        $implementation = [
            "TELEGRAM_AUTH" => fn() => $this->telegramImplementAuth($attribute),
            "WEB_AUTH" => fn() => $this->webImplementAuth($attribute),
        ];

        $implementation[$type_auth]();


        $body = [
            "message" => "Please input 2FA code, we send your mail"
        ];

        if ($this->uuid) {
            $body['uuid'] = $this->uuid;
        }

        return $body;
    }

    public function login($attribute)
    {
        $user = $this->userRepository->getByColumn("email", $attribute['email'])->first();
        if (!$user) {
            throw new \Exception("User not found", 404);
        }

        $type_auth = $attribute['type_auth_constant'];
        if (!$this->dictiRepository->checkTypeAuth($type_auth)) {
            throw new \Exception("Type auth not found", 422);
        }

        $implementation = [
            "TELEGRAM_AUTH" => fn() => $this->telegramImplementAuth($attribute),
            "WEB_AUTH" => fn() => $this->webImplementAuth($attribute),
        ];

        $implementation[$type_auth]();

        $body = [
            "message" => "Please input 2FA code, we send your mail"
        ];

        if ($this->uuid) {
            $body['uuid'] = $this->uuid;
        }

        return $body;
    }

    public function sendTwoFactor($mail, $twoFA)
    {
        Mail::to($mail)->send(new TwoFaMail($twoFA));
    }

    public function confirmTwoFactor($attribute)
    {
        if (isset($attribute['telegram_user_id'])) {
            $model = $this->twoFactorRepository->findToken($attribute['telegram_user_id'], $attribute['code']);
        } elseif (isset($attribute['uuid'])) {
            $model = $this->twoFactorRepository->findTokenByUuid($attribute['uuid'], $attribute['code']);
        } else {
            $model = null;
        }

        if (!isset($model) || !$model || now() > $model->code_expires_at) {
            throw new \Exception("Two factor to expired or uuid not found", 401);
        }

        $user = $this->userRepository->getByColumn("email", $model->email)->first();
        if (!$user) {
            $registerData = json_decode($model->register_data, true);
            if (!isset($registerData['full_name'])) {
                if (isset($registerData['first_name'])) {
                    $registerData['full_name'] = "Пользователь";
                } else {
                    $registerData['full_name'] = $registerData['first_name'];
                    if (isset($registerData['last_name'])) {
                        $registerData['full_name'] = $registerData['full_name'] . ' ' . $registerData['last_name'];
                    }
                }
            }
            $user = $this->userRepository->create($registerData);
        }
        Auth::login($user);

        return [
            "message" => "You are registred"
        ];
    }

    public function telegramImplementAuth($attribute)
    {
        $twoFA = $this->twoFactorRepository->create([
            "email" => $attribute['email'],
            "register_data" => json_encode($attribute),
            "telegram_user_id" => $attribute["telegram_user_id"]
        ]);

        $this->sendTwoFactor($twoFA->email, $twoFA->two_factor_code);
    }

    public function webImplementAuth($attribute)
    {
        $twoFA = $this->twoFactorRepository->create([
            "email" => $attribute['email'],
            "register_data" => json_encode($attribute)
        ]);

        $this->sendTwoFactor($twoFA->email, $twoFA->two_factor_code);
        $this->uuid = $twoFA->uuid;
    }
}
