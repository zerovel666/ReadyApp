<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "model" => new CarModelResource($this->model),
            "color" => $this->carEquipment->color,
            "partner" => $this->partner,
            "vin" => $this->vin,
            "license_plate" => $this->license_plate,
            "mileage" => $this->mileage,
            "last_inspection_date" => $this->last_inspection_date,
            "date_release" => $this->date_release,
            "rating" => $this->rating,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];

        return $baseArray;
    }
}