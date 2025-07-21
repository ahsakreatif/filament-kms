<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'abstract',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'mime_type',
        'category_id',
        'uploaded_by',
        'author',
        'keywords',
        'publication_year',
        'doi',
        'isbn',
        'language',
        'is_public',
        'is_featured',
        'download_count',
        'view_count',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'document_tag');
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(DocumentDownload::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(DocumentView::class);
    }

    public function forumThreads(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ForumThread::class, 'document_forum_thread');
    }
}
