<?php

namespace App\Http\Controllers\Api\V1\Chat;

use App\Events\PrivateConversationMessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\PrivateConversationRequest;
use App\Http\Resources\ConversationMessageResource;
use App\Http\Traits\MediaUpload;
use App\Models\ChatList;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\ConversationMessageMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PrivateConversationController extends Controller implements HasMiddleware
{
    use MediaUpload;

    public static function middleware(): array
    {
        return [new Middleware('auth:api')];
    }

    public function sendMessage(PrivateConversationRequest $request): JsonResponse
    {
        try {
            $senderId = auth()->id();
            $receiverId = $request->receiver_id;

            $conversation = $this->findOrCreateConversation((int)$senderId, (int)$receiverId);

            $this->firstOrCreateChatList((int)$senderId, (int)$conversation->id);

            $conversationMessage = ConversationMessage::create([
                'sender_id' => $senderId,
                'conversation_id' => $conversation->id,
                'content' => $request->content ?? null,
                'message_type' => $request->message_type,
            ]);

            if($request->message_type === 'media') {
                $path = $this->uploadMedia($request->media->media_file, $request->media->media_type);

                ConversationMessageMedia::create([
                    "conversation_message_id" => $conversationMessage->id,
                    "media_type" => $request->media->media_type,
                    "media_path" => $path,
                    "caption" => $request->media->caption ?? null,
                ]);
            }

            $conversationMessage->load('conversationMessageMedia');

            $messageResource = new ConversationMessageResource($conversationMessage);

            PrivateConversationMessageSent::dispatch($conversation, $messageResource);

            return $this->responseWithResult('success', 'Message sent successfully.', 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    private function findOrCreateConversation(int $senderId, int  $receiverId): Conversation
    {
        return Conversation::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })->first() ?? Conversation::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
        ]);
    }

    private function firstOrCreateChatList(int $userId, int $conversationId): ChatList
    {
        return ChatList::firstOrCreate([
             'user_id' => $userId,
             'chat_type' => Conversation::class,
             'chat_id' => $conversationId,
         ]);
    }
}
