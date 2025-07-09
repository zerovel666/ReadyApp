<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class DictiResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        return [
            "id" => $this->id,
            "full_name" => $this->full_name,
            "parent_id" => $this->parent_id,
            "char_value" => $this->char_value,
            "num_value" => $this->num_value,
            "json_value" => $this->json_value,
            "constant" => $this->constant,
            "constant1" => $this->constant1,
            "constant2" => $this->constant2,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
