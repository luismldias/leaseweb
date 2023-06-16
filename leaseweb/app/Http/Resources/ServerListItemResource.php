<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServerListItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $out = [
            'id'       => $this->id,
            'model'    => $this->model,
            'ram'      => $this->ram_info,
            'hdd'      => $this->hdd_info,
            'price'    => $this->price,
            'location' => $this->location ? $this->location->name : '',
        ];

        return $out;
    }
}