<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'recovery_email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'enabled_two_factor' => 'boolean',
            'additional_password' => 'hashed',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array<mixed>
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ChatList>
     */
    public function chatLists(): HasMany
    {
        return $this->hasMany(ChatList::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Conversation>
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user1_id')->orWhere('user2_id', $this->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<GroupChat>
     */
    public function groupChats(): BelongsToMany
    {
        return $this->belongsToMany(GroupChat::class, 'group_chat_members');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Channel>
     */
    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(Channel::class, 'channel_subscribers');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ConversationMessageDeletion>
     */
    public function conversationMessageDeletion(): HasMany
    {
        return $this->hasMany(ConversationMessageDeletion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<PinnedMessage>
     */
    public function pinnedMessages(): HasMany
    {
        return $this->hasMany(PinnedMessage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<PinnedEntity>
     */
    public function pinnedEntities(): HasMany
    {
        return $this->hasMany(PinnedEntity::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Contact>
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'phone_number', 'phone_number');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Folder>
     */
    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function blockedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id')->withTimestamps();
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<ConversationMessage>
    */
    public function readConversationMessages(): BelongsToMany
    {
        return $this->belongsToMany(ConversationMessage::class, 'conversation_message_reads', 'user_id', 'conversation_message_id')->withTimestamps();
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<GroupChatMessage>
    */
    public function readGroupChatMessages(): BelongsToMany
    {
        return $this->belongsToMany(GroupChatMessage::class, 'group_chat_message_reads', 'user_id', 'group_chat_message_id')->withTimestamps();
    }
}
