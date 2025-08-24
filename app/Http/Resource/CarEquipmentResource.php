<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class CarEquipmentResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            'car_model_id' => $this->carModel,
            "active" => $this->active,
            "color" => $this->color,
            "amount" => $this->amount,
            "currency" => $this->currency,
            'image' => $this->carImages,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

        return $baseArray;
    }
}
