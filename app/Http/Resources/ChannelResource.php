<?php

namespace App\Http\Resources;

use App\Models\ChannelSubscriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $owner = ChannelSubscriber::where("role", "owner")->first();

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'notification_mute_status' => $this->resource->notification_mute_status,
            'owner' => $owner ? new UserResource($owner) : null,
            'subscriber_count' => $this->subscribers->count()
        ];
    }
}
