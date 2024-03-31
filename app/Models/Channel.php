<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Channel extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ChannelMessage>
     */
    public function channelMessages(): HasMany
    {
        return $this->hasMany(ChannelMessage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'channel_subscribers');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<PinnedEntity>
     */
    public function pinnedEntity(): HasOne
    {
        return $this->hasOne(PinnedEntity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany<Folder>
     */
    public function folders(): MorphToMany
    {
        return $this->morphToMany(Folder::class, 'folderable');
    }
}
