<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "car_id" => $this->car,
            "user_id" => $this->user,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "status" => $this->status,
            "notified" => $this->notified,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];

        return $baseArray;
    }
}