<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class DamageNoteResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "car_id" => $this->car_id,
            "task_id" => $this->task_id,
            "check_list_item_id" => $this->check_list_item_id,
            "longitude" => $this->longitude,
            "latitude" => $this->latitude,
            "is_resolved" => $this->is_resolved,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];

        return $baseArray;
    }
}