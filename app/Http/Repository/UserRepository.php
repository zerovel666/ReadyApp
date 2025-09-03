<?php

namespace App\Http\Repository;

use App\Models\Role;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function checkHasUser($attribute)
    {
        return $this->model
            ->where("active", true)
            ->where("email", $attribute["email"])
            ->exists();
    }

    public function findFreeManager()
    {
        $managerRoleId = Role::where('slug', 'manager')->value('id');

        return $this->model
            ->whereHas('roles', fn($q) => $q->where('role_id', $managerRoleId))
            ->withCount([
                'taskManager as active_requests_count' => fn($q) => $q->where('resolved', false)
            ])
            ->orderBy('active_requests_count')
            ->first();
    }
}
