<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportRequestResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "user_id" => $this->user,
            "manager_id" => $this->manager,
            "description" => $this->description,
            "booking_id" => $this->booking,
            "resolved" => $this->resolved,
        ];

        return $baseArray;
    }
}