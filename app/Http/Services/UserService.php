<?php

namespace App\Http\Services;

use App\Http\Repository\RoleRepository;
use App\Http\Repository\TwoFactorTokenRepository;
use App\Http\Repository\UserRepository;
use App\Mail\CreateUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserService extends BaseService
{
    protected $roleRepository;
    protected $twoFactorRepository;
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository,TwoFactorTokenRepository $twoFactorRepository)
    {
        parent::__construct($userRepository);
        $this->roleRepository = $roleRepository;
        $this->twoFactorRepository = $twoFactorRepository;
    }

    public function attachRole($attributes)
    {
        $this->repository->find($attributes['user_id'])->roles()->attach($attributes['role_id']);
        return [
            "message" => "Success add role"
        ];
    }

    public function destroyUserRole($attributes)
    {
        $this->repository->find($attributes['user_id'])
            ->roles()
            ->detach($attributes['role_id']);
        return [
            "message" => "Success delete user role"
        ];
    }

    public function create($data)
    {
        $user = $this->repository->create($data);
        $twoFA = $this->createTwoFactor($data['email']);
        $baseUrl = config("app.url");
        Mail::to($data['email'])->send(new CreateUserMail(
            "The admin has created an account for you in the Ready Drive system. Please follow the following link in order to finally register in the system. $baseUrl/$twoFA->two_factor_code"
        ));

        return $user;
    }

    public function createTwoFactor($email)
    {
        return $this->twoFactorRepository->create([
            "email" => $email
        ]);
    }

    public function updateByTwoFa($request,$twoFa)
    {
        $twoFa = $this->twoFactorRepository->getByMultipieColumns([
            "email" => $request->email,
            "two_factor_code" => $twoFa
        ])->first();
        
        if (!$twoFa){
            throw new \Exception("TwoFa not found",404);
        }

        $user = $this->repository->firstByColumn("email",$request->email);
        $filepath = Storage::disk('public')->put("avatar/$user->id",$request->file('avatar'));
        $attribute = $request->all();
        $attribute['avatar'] = $filepath;

        $user->update($attribute);

        return $user;
    }
}

