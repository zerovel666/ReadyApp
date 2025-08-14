<?php

namespace App\Http\Services\V2;

use App\Http\Repository\DictiRepository;
use App\Http\Repository\RoleRepository;
use App\Http\Repository\TwoFactorTokenRepository;
use App\Http\Repository\UserRepository;
use App\Http\Resource\UserResource;
use App\Models\PersonalAccessToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthServiceV2
{
    public $dictiRepository;
    public $userRepository;
    public $twoFactorRepository;
    public $roleRepository;
    public function __construct(DictiRepository $dictiRepository, UserRepository $userRepository, TwoFactorTokenRepository $twoFactorRepository,RoleRepository $roleRepository)
    {
        $this->dictiRepository = $dictiRepository;
        $this->userRepository = $userRepository;
        $this->twoFactorRepository = $twoFactorRepository;
        $this->roleRepository = $roleRepository;
    }

    public function register($attribute)
    {
        $type_auth = $attribute['type_auth_constant'];
        if (!$this->dictiRepository->checkTypeAuth($type_auth)) {
            throw new \Exception("Type auth not found", 422);
        }

        $user = $this->userRepository->firstByColumn("phone", $attribute['phone']);

        if ($user) {

            return $this->formResponse($user);
        }

        $implements = [
            "WEB_AUTH" => fn() => $this->webRegisterImplement($attribute),
            "TELEGRAM_AUTH" => fn() => $this->telegramRegisterImplement($attribute)
        ];

        return $implements[$type_auth]();
    }

    public function webRegisterImplement($attribute)
    {
        $user = $this->userRepository->create($attribute);
        $user->roles()->attach($this->roleRepository->getByColumn("slug","standart")->first()['id']);
        $user->update([
            "last_verifed" => now()->format("Y-m-d")
        ]);
        return $this->formResponse($user);
    }

    public function telegramRegisterImplement($attribute)
    {
        $user = $this->userRepository->create($attribute);
        $user->roles()->attach($this->roleRepository->getByColumn("slug","standart")->first()['id']);
        $user->update([
            "last_verifed" => now()->format("Y-m-d")
        ]);
        return $this->formResponse($user);
    }

    public function login($attribute)
    {
        $type_auth = $attribute['type_auth_constant'];
        if (!$this->dictiRepository->checkTypeAuth($type_auth)) {
            throw new \Exception("Type auth not found", 422);
        }

        $user = $this->userRepository->firstByColumn("phone", $attribute['phone']);
        if (!$user) {
            throw new \Exception("User not found", 404);
        }


        $implements = [
            "WEB_AUTH" => fn() => $this->webLoginImplement($attribute),
            "TELEGRAM_AUTH" => fn() => $this->telegramLoginImplement($attribute)
        ];

        return $implements[$type_auth]();
    }

    public function webLoginImplement($attribute)
    {
        $user = $this->userRepository->firstByColumn("phone", $attribute['phone']);

        if (!$user || !Hash::check($attribute['password'], $user->password)) {
            throw new \Exception("Invalid credentials", 401);
        }

        return $this->formResponse($user);
    }


    public function telegramLoginImplement($attribute)
    {
        $user = $this->userRepository->getByMultipieColumns([
            "phone" => $attribute['phone'],
            "telegram_user_id" => $attribute['telegram_user_id']
        ])->first();

        if (!$user) {
            throw new \Exception("User not found", 404);
        }

        return $this->formResponse($user);
    }

    public function formResponse($user)
    {
        $tokenModel = $user->createToken("webApp", ['*'], now()->addDays(15));
        $accessToken = $tokenModel->plainTextToken;
        $refreshToken = $tokenModel->accessToken->refresh_token;
        return [
            "message" => "Success auth",
            "token" => $accessToken,
            "refresh_token" => $refreshToken,
            "user" => new UserResource($user)
        ];
    }

    public function refreshUserToken($refreshToken, $user_id)
    {
        $user = $this->userRepository->firstByColumn("telegram_user_id", $user_id) 
            ?? $this->userRepository->find($user_id);

        if (!$user) {
            throw new \Exception("User not found", 404);
        }

        $userToken = PersonalAccessToken::where("refresh_token", $refreshToken)
            ->where("tokenable_id", $user->id)
            ->first();

        if (!$userToken) {
            throw new \Exception("Invalid refresh token", 401);
        }

        if ($userToken->expires_at_refresh_token && Carbon::parse($userToken->expires_at_refresh_token)->isPast()) {
            throw new \Exception("Refresh token expired", 422);
        }

        return $this->formResponse($user);
    }

}
