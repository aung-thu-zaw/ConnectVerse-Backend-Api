<?php

use App\Broadcasting\PrivateConversationChannel;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('private-conversation.{conversation}', PrivateConversationChannel::class);
