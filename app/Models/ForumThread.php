<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kirschbaum\Commentions\Contracts\Commentable;
use Kirschbaum\Commentions\HasComments;
use App\Traits\HasForumThreadStats;

class ForumThread extends Model implements Commentable
{
    use HasFactory, HasComments, HasForumThreadStats;

    protected $fillable = [
        'title',
        'body',
        'forum_topic_id',
        'category_id',
        'user_id',
        'likes_count',
        'views_count',
        'unique_views_count',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(ForumTopic::class, 'forum_topic_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'forum_thread_tag');
    }

    public function documents(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'document_forum_thread');
    }

    public function views(): HasMany
    {
        return $this->hasMany(ForumThreadView::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ForumThreadLike::class);
    }

    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'forum_thread_likes');
    }

    public function viewedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'forum_thread_views');
    }
}
