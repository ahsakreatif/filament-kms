<?php

namespace App\Traits;

use App\Models\DocumentDownload;
use App\Models\DocumentView;
use App\Models\DocumentFavorite;
use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;

trait HasDocumentStats
{
    /**
     * Record a view for the document
     */
    public function recordView(): void
    {
        $userId = Auth::id();
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        // Check if this user has already viewed this document recently (within 24 hours)
        $recentView = $this->views()
            ->where('user_id', $userId)
            ->where('viewed_at', '>=', now()->subDay())
            ->first();

        if (!$recentView) {
            $this->views()->create([
                'user_id' => $userId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'viewed_at' => now(),
            ]);

            // Update denormalized counts
            $this->increment('view_count');

            // Update recommendation preferences
            if ($userId) {
                $user = Auth::user();
                app(RecommendationService::class)->recordView($user, $this);
            }
        }
    }

    /**
     * Record a download for the document
     */
    public function recordDownload(): void
    {
        $userId = Auth::id();
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        // Check if this user has already downloaded this document recently (within 24 hours)
        $recentDownload = $this->downloads()
            ->where('user_id', $userId)
            ->where('downloaded_at', '>=', now()->subDay())
            ->first();

        if (!$recentDownload) {
            $this->downloads()->create([
                'user_id' => $userId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'downloaded_at' => now(),
            ]);

            // Update denormalized counts
            $this->increment('downloads_count');

            // Update recommendation preferences
            if ($userId) {
                $user = Auth::user();
                app(RecommendationService::class)->recordDownload($user, $this);
            }
        }
    }

    /**
     * Toggle favorite for the current user
     */
    public function toggleFavorite(): bool
    {
        $userId = Auth::id();

        if (!$userId) {
            return false;
        }

        $existingFavorite = $this->favorites()->where('user_id', $userId)->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            $this->decrement('favorites_count');
            return false; // Unfavorite
        } else {
            $this->favorites()->create([
                'user_id' => $userId,
                'favorited_at' => now(),
            ]);
            $this->increment('favorites_count');

            // Update recommendation preferences
            $user = Auth::user();
            app(RecommendationService::class)->recordFavorite($user, $this);

            return true; // Favorite
        }
    }

    /**
     * Check if the current user has favorited this document
     */
    public function isFavoritedByCurrentUser(): bool
    {
        $userId = Auth::id();

        if (!$userId) {
            return false;
        }

        return $this->favorites()->where('user_id', $userId)->exists();
    }

    /**
     * Check if the current user has downloaded this document
     */
    public function isDownloadedByCurrentUser(): bool
    {
        $userId = Auth::id();

        if (!$userId) {
            return false;
        }

        return $this->downloads()->where('user_id', $userId)->exists();
    }

    /**
     * Get the total number of downloads
     */
    public function getRealDownloadsCountAttribute(): int
    {
        return $this->downloads()->count();
    }

    /**
     * Get the total number of views
     */
    public function getRealViewsCountAttribute(): int
    {
        return $this->views()->count();
    }

    /**
     * Get the total number of favorites
     */
    public function getRealFavoritesCountAttribute(): int
    {
        return $this->favorites()->count();
    }

    /**
     * Get unique views count (by user)
     */
    public function getRealUniqueViewsCountAttribute(): int
    {
        return $this->views()->distinct('user_id')->count('user_id');
    }

    /**
     * Get unique downloads count (by user)
     */
    public function getRealUniqueDownloadsCountAttribute(): int
    {
        return $this->downloads()->distinct('user_id')->count('user_id');
    }
}
