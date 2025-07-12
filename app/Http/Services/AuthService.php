<?php

namespace App\Http\Services;

use App\Http\Helpers\Response;
use App\Http\Repository\DictiRepository;
use App\Http\Repository\TwoFactorTokenRepository;
use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthService
{
    public $userRepository;
    public $twoFactorRepository;
    public $dictiRepository;

    public function __construct(UserRepository $userRepository, TwoFactorTokenRepository $twoFactorTokenRepository, DictiRepository $dictiRepository)
    {
        $this->userRepository = $userRepository;
        $this->twoFactorRepository = $twoFactorTokenRepository;
        $this->dictiRepository = $dictiRepository;
    }

    public function register($attribute)
    {
        $type_auth = $attribute['type_auth_id'];
        if (!$this->dictiRepository->checkTypeAuth($type_auth)) {
            throw new \Exception("Type auth not found", 422);
        }

        if ($this->userRepository->checkHasUser($attribute)){
            throw new \Exception("A user with such an email/phone/unique identifier is busy.",400);
        }

    }

    public function login($attribute) 
    {
       
    }

    public function sendTwoFactor() 
    {
        //send mail

    }

    public function confirmTwoFactor($attribute) 
    {
        $model = $this->twoFactorRepository->findByUuid($attribute['uuid']);

        if (!$model && now() > $model->expired){
            throw new \Exception("Two factor to expired or uuid not found");
        }
    }
}
