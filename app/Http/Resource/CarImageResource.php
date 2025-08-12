<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CarImageResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "model_id" => $this->model_id,
            "filepath" => Storage::url($this->filepath),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];

        return $baseArray;
    }
}