<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumThreadLike extends Model
{
    protected $fillable = [
        'forum_thread_id',
        'user_id',
        'liked_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'liked_at' => 'datetime',
    ];

    public function forumThread(): BelongsTo
    {
        return $this->belongsTo(ForumThread::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
