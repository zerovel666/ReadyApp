<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoCodeResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "code" => $this->code,
            "user_id" => $this->user,
            "expired_at" => $this->expired_at,
            "percent" => $this->percent,
            "count_use_limit" => $this->count_use_limit,
            "count_use" => $this->count_use,
            "is_global" => $this->is_global,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];

        return $baseArray;
    }
}