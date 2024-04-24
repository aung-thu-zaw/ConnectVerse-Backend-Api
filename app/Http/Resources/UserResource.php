<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "avatar" => $this->resource->avatar,
            "username" => $this->resource->username,
            "display_name" => $this->resource->display_name,
            "phone_number" => $this->resource->phone_number,
            "phone_country_code" => $this->resource->phone_country_code,
            "phone_verified_at" => $this->resource->phone_verified_at,
            "recovery_email" => $this->resource->recovery_email,
            "recovery_email_verified_at" => $this->resource->recovery_email_verified_at,
        ];
    }
}
