<?php

namespace App\Traits;

use App\Models\ForumThreadLike;
use App\Models\ForumThreadView;
use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;

trait HasForumThreadStats
{
    /**
     * Record a view for the forum thread
     */
    public function recordView(): void
    {
        $userId = Auth::id();
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        // Check if this user has already viewed this thread recently (within 24 hours)
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
            $this->increment('views_count');

            // Update unique views count if this is a new user
            if ($userId && $this->views()->where('user_id', $userId)->count() === 1) {
                $this->increment('unique_views_count');
            }

            // Update recommendation preferences
            if ($userId) {
                $user = Auth::user();
                app(RecommendationService::class)->recordView($user, $this);
            }
        }
    }

    /**
     * Toggle like for the current user
     */
    public function toggleLike(): bool
    {
        $userId = Auth::id();

        if (!$userId) {
            return false;
        }

        $existingLike = $this->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete();
            $this->decrement('likes_count');
            return false; // Unlike
        } else {
            $this->likes()->create([
                'user_id' => $userId,
                'liked_at' => now(),
            ]);
            $this->increment('likes_count');

            // Update recommendation preferences
            $user = Auth::user();
            app(RecommendationService::class)->recordLike($user, $this);

            return true; // Like
        }
    }

    /**
     * Check if the current user has liked this thread
     */
    public function isLikedByCurrentUser(): bool
    {
        $userId = Auth::id();

        if (!$userId) {
            return false;
        }

        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Get the total number of likes
     */
    public function getRealLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }

    /**
     * Get the total number of views
     */
    public function getRealViewsCountAttribute(): int
    {
        return $this->views()->count();
    }

    /**
     * Get unique views count (by user)
     */
    public function getRealUniqueViewsCountAttribute(): int
    {
        return $this->views()->distinct('user_id')->count('user_id');
    }
}
