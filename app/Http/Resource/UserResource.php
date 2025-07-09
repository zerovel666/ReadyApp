<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "email" => $this->email,
            "password" => $this->password,
            "first_name" => $this->first_name,
            "parent_name" => $this->parent_name,
            "last_name" => $this->last_name,
            "full_name" => $this->full_name,
            "country_id" => $this->country_id,
            "uniq_id_people" => $this->uniq_id_people,
            "partner_id" => $this->partner_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];

        return $baseArray;
    }
}