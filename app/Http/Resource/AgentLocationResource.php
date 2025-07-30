<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class AgentLocationResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "agent_id" => $this->agent_id,
            "longitude" => $this->longitude,
            "latitude" => $this->latitude,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];

        return $baseArray;
    }
}