<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'private_my_phone' => 'boolean',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,Contact>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function phoneOwner(): HasOne
    {
        return $this->hasOne(User::class, 'phone_number', 'phone_number');
    }
}
