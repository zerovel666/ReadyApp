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
            "car_id" => $this->car_id,
            "booking_id" => $this->booking_id,
            "type_id" => $this->type_id,
            "longitude_a" => $this->longitude_a,
            "latitude_a" => $this->latitude_a,
            "longitude_b" => $this->longitude_b,
            "latitude_b" => $this->latitude_b,
            "date_time_complete" => $this->date_time_complete,
            "check_list_id" => $this->check_list_id,
            "description" => $this->description,
            "updated_at" => $this->updated_at,  
        ];

        return $baseArray;
    }
}