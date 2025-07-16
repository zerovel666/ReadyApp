<?php

namespace App\Http\Services;

use App\Http\Repository\RoleRepository;

class RoleService extends BaseService
{
    public function __construct(RoleRepository $roleRepository)
    {
        parent::__construct($roleRepository);
    }

    public function list()
    {
        return $this->repository->getWithChildren();
    }
}
