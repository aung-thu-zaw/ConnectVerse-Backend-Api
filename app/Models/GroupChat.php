<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class GroupChat extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<GroupChatMessage>
     */
    public function groupChatMessages(): HasMany
    {
        return $this->hasMany(GroupChatMessage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_chat_members');
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
