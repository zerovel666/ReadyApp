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
            "image_path" => Storage::url($this->image_path),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];

        return $baseArray;
    }
}