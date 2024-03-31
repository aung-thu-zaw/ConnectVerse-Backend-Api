<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupChatMember extends Pivot
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<GroupChat,GroupChatMember>
     */
    public function groupChat(): BelongsTo
    {
        return $this->belongsTo(GroupChat::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,GroupChatMember>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
