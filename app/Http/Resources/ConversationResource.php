<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $sender = User::findOrFail($this->resource->sender_id);
        $receiver = User::findOrFail($this->resource->receiver_id);

        return [
            'id' => $this->resource->id,
            'notification_mute_status' => $this->resource->notification_mute_status,
            'sender' => $sender ? new UserResource($sender) : null,
            'receiver' => $receiver ? new UserResource($receiver) : null,
        ];
    }
}
