<?php

namespace App\Http\Services;

use App\Http\Repository\RoleRepository;
use App\Http\Repository\UserRepository;

class UserService extends BaseService
{
    protected $roleRepository;
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        parent::__construct($userRepository);
        $this->roleRepository = $roleRepository;
    }

    public function attachRole($attributes)
    {
        return $this->repository->find($attributes['user_id'])->roles()->attach($attributes['role_id']);
    }

    public function destroyUserRole($attributes)
    {
        return $this->repository
            ->find($attributes['user_id'])
            ->roles()
            ->detach($attributes['role_id']);
    }
}
