<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConversationMessageMedia extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ConversationMessage,ConversationMessageMedia>
     */
    public function conversationMessage(): BelongsTo
    {
        return $this->belongsTo(ConversationMessage::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ConversationMessageMedia,ConversationMessageMedia>
     */
    public function repliedToMessage(): BelongsTo
    {
        return $this->belongsTo(ConversationMessageMedia::class, 'reply_to_message_id');
    }
}
