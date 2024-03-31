<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GroupChatMessageMedia extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GroupChatMessage,GroupChatMessageMedia>
     */
    public function groupChatMessage(): BelongsTo
    {
        return $this->belongsTo(GroupChatMessage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GroupChatMessageMedia,GroupChatMessageMedia>
     */
    public function repliedToMessage(): BelongsTo
    {
        return $this->belongsTo(GroupChatMessageMedia::class, 'reply_to_message_id');
    }
}
