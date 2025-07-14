<?php

namespace App\Http\Repository;

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
}
