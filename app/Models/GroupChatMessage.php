<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GroupChatMessage extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,GroupChatMessage>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GroupChat,GroupChatMessage>
     */
    public function groupChat(): BelongsTo
    {
        return $this->belongsTo(GroupChat::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<GroupChatMessageMedia>
     */
    public function groupChatMessageMedia(): HasMany
    {
        return $this->hasMany(GroupChatMessageMedia::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GroupChatMessage,GroupChatMessage>
     */
    public function repliedToMessage(): BelongsTo
    {
        return $this->belongsTo(GroupChatMessage::class, 'reply_to_message_id');
    }
}
