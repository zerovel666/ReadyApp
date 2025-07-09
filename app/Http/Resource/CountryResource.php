<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "parent_countries_id" => $this->parent_countries_id,
            "name" => $this->name,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];

        if ($this->children){
            $baseArray['children'] = $this->children;
        }

        return $baseArray;
    }
}