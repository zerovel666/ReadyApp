<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "model_id" => $this->model_id,
            "partner_id" => $this->partner_id,
            "vin" => $this->vin,
            "license_plate" => $this->license_plate,
            "color_id" => $this->color_id,
            "mileage" => $this->mileage,
            "last_inspection_date" => $this->last_inspection_date,
            "date_release" => $this->date_release,
            "rating" => $this->rating,
            "status " => $this->status,
            "amount" => $this->amount,
            "currency_id" => $this->currency_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];

        return $baseArray;
    }
}