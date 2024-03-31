<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChannelSubscriber extends Pivot
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Channel,ChannelSubscriber>
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,ChannelSubscriber>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
