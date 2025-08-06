<?php

namespace App\Services;

use App\Models\ForumThread;
use App\Models\UserTagPreference;
use Illuminate\Support\Facades\DB;

class ForumThreadStatsService
{
    /**
     * Get popular threads by likes
     */
    public function getPopularThreadsByLikes(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return ForumThread::orderBy('likes_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get popular threads by views
     */
    public function getPopularThreadsByViews(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return ForumThread::orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get threads with statistics
     */
    public function getThreadsWithStats(int $limit = 20): \Illuminate\Database\Eloquent\Collection
    {
        return ForumThread::with(['user', 'topic', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get user's liked threads
     */
    public function getUserLikedThreads(int $userId, int $limit = 20): \Illuminate\Database\Eloquent\Collection
    {
        return ForumThread::whereHas('likes', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->withCount(['likes', 'views'])
        ->with(['user', 'topic', 'category'])
        ->orderBy('created_at', 'desc')
        ->limit($limit)
        ->get();
    }

    /**
     * Get threads viewed by user
     */
    public function getUserViewedThreads(int $userId, int $limit = 20): \Illuminate\Database\Eloquent\Collection
    {
        return ForumThread::whereHas('views', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->withCount(['likes', 'views'])
        ->with(['user', 'topic', 'category'])
        ->orderBy('created_at', 'desc')
        ->limit($limit)
        ->get();
    }

    /**
     * Get daily statistics for a thread
     */
    public function getThreadDailyStats(int $threadId, int $days = 30): array
    {
        $stats = DB::table('forum_thread_views')
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
            ->where('forum_thread_id', $threadId)
            ->where('viewed_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $stats->toArray();
    }

    /**
     * Get like statistics for a thread
     */
    public function getThreadLikeStats(int $threadId, int $days = 30): array
    {
        $stats = DB::table('forum_thread_likes')
            ->selectRaw('DATE(liked_at) as date, COUNT(*) as likes')
            ->where('forum_thread_id', $threadId)
            ->where('liked_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $stats->toArray();
    }

    /**
     * Get most active user
     */
    public function getMostActiveUser(): \Illuminate\Database\Eloquent\Model | null
    {
        return UserTagPreference::select(DB::raw('sum(total_score) as total_score'), 'user_id')
            ->groupBy('user_id')
            ->orderBy('total_score', 'desc')
            ->first();
    }
}
