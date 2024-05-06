<?php

namespace App\Http\Resources;

use App\Models\GroupChatMember;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $owner = GroupChatMember::where("role", "owner")->first();

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'typing_allowed' => $this->resource->typing_allowed,
            'notification_mute_status' => $this->resource->notification_mute_status,
            'owner' => $owner ? new UserResource($owner) : null,
            'member_count' => $this->members->count()
        ];
    }
}
