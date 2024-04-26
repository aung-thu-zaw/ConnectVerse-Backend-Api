<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'phone_number' => $this->resource->phone_number,
            'phone_country_code' => $this->resource->phone_country_code,
            'private_my_phone' => $this->resource->private_my_phone,
            'associated_user' => [
                "id" => $this->resource->phoneOwner->id,
                "avatar" => $this->resource->phoneOwner->avatar,
                "username" => $this->resource->phoneOwner->username,
                "display_name" => $this->resource->phoneOwner->display_name
            ]
        ];
    }
}
