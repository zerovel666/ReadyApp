<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(\Illuminate\Http\Request $request)
    {
        $baseArray = [
            "id" => $this->id,
            "user_id" => $this->user,
            "agent_id" => $this->agent_id,
            "agentInfo" => $this->agent->user,
            "car_id" => $this->car,
            "booking_id" => $this->booking,
            "type_id" => $this->type,
            "status_id" => $this->status,
            "longitude_a" => $this->longitude_a,
            "latitude_a" => $this->latitude_a,
            "longitude_b" => $this->longitude_b,
            "latitude_b" => $this->latitude_b,
            "date_time_complete" => $this->date_time_complete,
            "check_list_id" => $this->check_list_id,
            "description" => $this->description,
            "updated_at" => $this->updated_at,  
            "yandex_map_link_a" => "https://yandex.kz/maps/?pt={$this->longitude_a},{$this->latitude_a}&z=16&l=map",
            "yandex_map_link_b" => "https://yandex.kz/maps/?pt={$this->longitude_b},{$this->latitude_b}&z=16&l=map",
        ];

        if ($this->check_list_id){
            $baseArray['check_list'] = $this->checkList->children->sortBy('order_no');
        }


        return $baseArray;
    }
}
