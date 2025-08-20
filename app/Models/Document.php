<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasDocumentStats;
use Filament\Facades\Filament;

class Document extends Model
{
    use HasDocumentStats;
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
        'downloads_count',
        'view_count',
        'favorites_count',
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

    public function favorites(): HasMany
    {
        return $this->hasMany(DocumentFavorite::class);
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'document_favorites');
    }

    public function toggleFavorite(): bool
    {
        $userId = Filament::auth()->id();

        $isFavorited = $this->favoritedBy()->where('user_id', $userId)->exists();
        if ($isFavorited) {
            $this->favoritedBy()->detach($userId);
        } else {
            $this->favoritedBy()->attach($userId);
        }
        return !$isFavorited;
    }

    public function recordDownload(): void
    {
        $userId = Filament::auth()->id();
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        $this->downloads()->create([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'downloaded_at' => now(),
        ]);

        $this->increment('downloads_count');
    }
}
