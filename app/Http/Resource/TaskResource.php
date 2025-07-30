<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "agent_id" => $this->agent_id,
            "address_a" => $this->address_a,
            "address_b" => $this->address_b,
            "date_time_complete" => $this->date_time_complete,
            "check_list_id" => $this->check_list_id,
            "description" => $this->description,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,  
        ];

        return $baseArray;
    }
}