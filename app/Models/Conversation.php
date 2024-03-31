<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Conversation extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ConversationMessage>
     */
    public function conversationMessages(): HasMany
    {
        return $this->hasMany(ConversationMessage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,Conversation>
     */
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,Conversation>
     */
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2_id');
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
