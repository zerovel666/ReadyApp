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
            ->where(function ($query) use ($attribute) {
                $query->where("email", $attribute["email"])
                    ->orWhere("uniq_id_people", $attribute["uniq_id_people"])
                    ->orWhere("phone", $attribute["phone"]);
            })
            ->exists();
    }
}
