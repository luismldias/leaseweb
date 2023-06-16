<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ServerCollection;

class AppStructureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'filters'         => $this->resource['filters'],
            'initial_content' => new ServerCollection($this->resource['initial_list']),
        ];
    }
}
