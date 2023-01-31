<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class UrlResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'destination' => $this->destination,
            'shortened_url' => $this->shortened_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
