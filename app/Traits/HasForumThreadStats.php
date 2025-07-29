<?php

namespace App\Traits;

use App\Models\ForumThreadLike;
use App\Models\ForumThreadView;
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
            if ($userId && !$this->views()->where('user_id', $userId)->where('id', '!=', $this->views()->latest()->first()->id)->exists()) {
                $this->increment('unique_views_count');
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
    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }

    /**
     * Get the total number of views
     */
    public function getViewsCountAttribute(): int
    {
        return $this->views()->count();
    }

    /**
     * Get unique views count (by user)
     */
    public function getUniqueViewsCountAttribute(): int
    {
        return $this->views()->distinct('user_id')->count('user_id');
    }
}
