<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckListResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "task_id" => $this->task,
            "field_name" => $this->field_name,
            "order_no" => $this->order_no,
            "damaged" => $this->damaged,
            "cheking" => $this->cheking,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];

        return $baseArray;
    }
}