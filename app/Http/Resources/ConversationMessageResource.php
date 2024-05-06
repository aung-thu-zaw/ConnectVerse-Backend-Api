<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationMessageResource extends JsonResource
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
            'conversation_id' => $this->resource->conversation_id,
            'sender_id' => $this->resource->sender_id,
            'content' => $this->resource->content,
            'message_type' => $this->resource->message_type,
            'media' => $this->resource->conversationMessageMedia->flatMap(function ($media) {
                return [
                    'conversation_message_id' => $media->conversation_message_id,
                    'media_type' => $media->media_type,
                    'media_path' => $media->media_path,
                    'caption' => $media->caption,
                ];
            })->all(),
        ];
    }
}
