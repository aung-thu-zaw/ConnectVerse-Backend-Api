<?php

namespace App\Http\Resources;

use App\Models\ChatList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChatListResource extends JsonResource
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
            'user_id' => $this->resource->user_id,
            'pinned' => $this->resource->pinned,
            'chat_type' => $this->resource->chat_type,
            'chat' => $this->getChatResource($this->resource->chat),
        ];
    }

    private function getChatResource(?Model $chat): ?object
    {
        switch ($this->resource->chat_type) {
            case 'App\Models\Conversation':
                return new ConversationResource($chat);
            case 'App\Models\GroupChat':
                return new GroupChatResource($chat);
            case 'App\Models\Channel':
                return new ChannelResource($chat);
            default:
                return null;
        }
    }
}
