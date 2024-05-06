<?php

namespace App\Events;

use App\Http\Resources\ConversationMessageResource;
use App\Models\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrivateConversationMessageSent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(protected Conversation $conversation, protected ConversationMessageResource $messageResource)
    {
        //
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('private-conversation.'.$this->conversation->id);
    }

    public function broadcastWith(): array
    {
        return [
            "message" => $this->messageResource
        ];
    }

    public function broadcastAs(): string
    {
        return 'private.message.sent';
    }

    public function broadcastQueue(): string
    {
        return 'default';
    }
}
