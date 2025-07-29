<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTagPreference extends Model
{
    protected $fillable = [
        'user_id',
        'tag_id',
        'like_score',
        'view_score',
        'total_score',
        'last_interaction_at',
    ];

    protected $casts = [
        'like_score' => 'float',
        'view_score' => 'float',
        'total_score' => 'float',
        'last_interaction_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
