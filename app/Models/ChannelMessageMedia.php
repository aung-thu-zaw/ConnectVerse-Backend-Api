<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChannelMessageMedia extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ChannelMessage,ChannelMessageMedia>
     */
    public function channelMessage(): BelongsTo
    {
        return $this->belongsTo(ChannelMessage::class);
    }
}
