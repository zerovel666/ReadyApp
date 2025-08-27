<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "email" => $this->email,
            "full_name" => $this->full_name,
            "country_id" => $this->country_id,
            "partner_id" => $this->partner_id,
            "telegram_chat_id" => $this->telegram_chat_id,
            "telegram_user_id" => $this->telegram_user_id,
            "uniq_id_people" => $this->uniq_id_people,
            "phone" => $this->phone,
            "active" => $this->active,
            "avatar" => $this->avatar ? Storage::url($this->avatar) : $this->avatar,
            "last_verifed" => $this->last_verifed,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];

        if ($this->agent){
            $baseArray['agent'] = $this->agent;
        }

        return $baseArray;
    }
}