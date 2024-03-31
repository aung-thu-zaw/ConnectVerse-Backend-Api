<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConversationMessage extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,ConversationMessage>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Conversation,ConversationMessage>
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ConversationMessageMedia>
     */
    public function conversationMessageMedia(): HasMany
    {
        return $this->hasMany(ConversationMessageMedia::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ConversationMessageDeletion>
     */
    public function conversationMessageDeletion(): HasMany
    {
        return $this->hasMany(ConversationMessageDeletion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ConversationMessage,ConversationMessage>
     */
    public function repliedToMessage(): BelongsTo
    {
        return $this->belongsTo(ConversationMessage::class, 'reply_to_message_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function readByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_message_reads', 'conversation_message_id', 'user_id')->withTimestamps();
    }

}
