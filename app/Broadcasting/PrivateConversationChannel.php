<?php

namespace App\Broadcasting;

use App\Models\Conversation;
use App\Models\User;

class PrivateConversationChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, Conversation $conversation): array|bool
    {
        return $user->conversations->contains($conversation);
    }
}
