<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PartnerResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "detail_info" => $this->detail_info,
            "email" => $this->email,
            "phone" => $this->phone,
            "country_id" => $this->country_id,
            "address" => $this->address,
            "logo_path" => Storage::url($this->logo_path) ?? null,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}