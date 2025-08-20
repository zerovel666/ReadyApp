<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            'id' => $this->id,
            "name" => $this->name,
            "brand_id" => $this->brand,
            "stamp_id" => $this->stamp,
            "body_id" => $this->body,
            "engine_id" => $this->engine,
            "transmission_id" => $this->transmission,
            "engine_volume" => $this->engine_volume,
            "power" => $this->power,
            "seats" => $this->seats,
            "doors" => $this->doors,
            "fuel_tank_capacity" => $this->fuel_tank_capacity,
            "weight" => $this->weight,
            "height" => $this->height,
            "active" => $this->active,
            "color_id" => $this->color,
            "amount" => $this->amount,
            "currency_id" => $this->currency,
            'image' => $this->carImages,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

        return $baseArray;
    }
}