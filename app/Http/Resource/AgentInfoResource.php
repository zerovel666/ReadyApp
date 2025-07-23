<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class AgentInfoResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "user_id" => $this->user,
            "status_id" => $this->status,
            "schedule_work_id" => $this->schedule_work,
            "count_сompleted_tasks" => $this->count_сompleted_tasks,
            "rating" => $this->rating,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];

        return $baseArray;
    }
}