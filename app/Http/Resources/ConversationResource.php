<?php

namespace App\Http\Resources;

use App\Helpers\DateTimeHelper;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\User;
use Carbon\Carbon;
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
        $data = [
            'id' => $this->resource->id,
            'notification_mute_status' => $this->resource->notification_mute_status,
            'sender' => $this->getUserResource($this->resource->sender_id),
            'receiver' => $this->getUserResource($this->resource->receiver_id),
            'total_unread_message_count' => $this->getUnreadMessageCount(),
            'both_read_last_message' => $this->getBothReadLastMessage(),
            'last_active_at' => $this->getLastActiveTime(),
        ];

        $lastMessage = $this->getLastMessage();

        if ($lastMessage) {
            $sender = $this->getUser($lastMessage->sender_id);

            if ($sender instanceof \App\Models\User) {
                if ($lastMessage->message_type === 'text') {
                    $data['last_sent_message'] = [
                        'sender' => $this->getSenderDisplayName($sender),
                        'message' => $lastMessage->content,
                    ];
                } elseif ($lastMessage->message_type === 'media') {
                    $data['last_sent_message'] = $this->getMediaMessage($lastMessage);
                }
            }
        }

        return $data;
    }

    private function getUserResource(int $userId): UserResource
    {
        return new UserResource(User::findOrFail($userId));
    }

    private function getUser(int $userId): ?User
    {
        return User::find($userId);
    }

    private function getUnreadMessageCount(): int
    {
        return ConversationMessage::where('conversation_id', $this->resource->id)
            ->where('sender_id', '!==', auth()->id())
            ->where('is_read_by_receiver', false)
            ->count();
    }

    private function getBothReadLastMessage(): bool
    {
        return ConversationMessage::where('conversation_id', $this->resource->id)
            ->where('is_read_by_receiver', true)
            ->where('is_read_by_sender', true)
            ->exists();
    }

    private function getLastActiveTime(): ?string
    {
        $lastMessage = $this->getLastMessage();
        return $lastMessage ? DateTimeHelper::formatLastActiveTime($lastMessage->created_at) : null;
    }

    private function getLastMessage(): ?ConversationMessage
    {
        return ConversationMessage::where('conversation_id', $this->resource->id)
            ->latest()
            ->first();
    }

    private function getSenderDisplayName(User $sender): string
    {
        return $sender->id === auth()->id() ? "You" : $sender->display_name;
    }

    /**
     * @return array<mixed>
     */
    private function getMediaMessage(ConversationMessage $lastMessage): array
    {
        $mediaFiles = $lastMessage->conversationMessageMedia()->get();
        $photos = [];
        $videos = [];
        $applications = [];

        foreach ($mediaFiles as $media) {
            switch ($media->media_type) {
                case 'image':
                    $photos[] = $media->media_path;
                    break;
                case 'video':
                    $videos[] = $media->media_path;
                    break;
                case 'application':
                    $applications[] = $media->media_path;
                    break;
            }
        }

        $messageContent = '';

        if (count($photos) > 0) {
            $messageContent .= count($photos) . ' photos, ';
        }
        if (count($videos) > 0) {
            $messageContent .= count($videos) . ' videos, ';
        }
        if (count($applications) > 0) {
            $messageContent .= count($applications) . ' files, ';
        }

        $messageContent = rtrim($messageContent, ', ');

        return [
            'sender' => $this->getSenderDisplayName(User::findOrFail($lastMessage->sender_id)),
            'files' => [...$photos, ...$videos, ...$applications],
            'message' => $messageContent,
        ];
    }

}
