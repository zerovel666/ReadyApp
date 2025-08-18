<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'stamp' => $this->stamp,
            'body' => $this->body,
            'engine' => $this->engine,
            'transmission' => $this->transmission,
            'engine_volume' => $this->engine_volume,
            'power' => $this->power,
            'seats' => $this->seats,
            'doors' => $this->doors,
            'fuel_tank_capacity' => $this->fuel_tank_capacity,
            'weight' => $this->weight,
            'height' => $this->height,
            'active' => $this->active,
            'image' => $this->carImages,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

        return $baseArray;
    }
}