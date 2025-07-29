<?php

namespace App\Http\Controllers;

use App\Models\ForumThread;
use App\Services\ForumThreadStatsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ForumThreadController extends Controller
{
    protected ForumThreadStatsService $statsService;

    public function __construct(ForumThreadStatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    /**
     * Display a forum thread and record the view
     */
    public function show(ForumThread $forumThread): \Illuminate\View\View
    {
        // Record the view
        $forumThread->recordView();

        return view('forum.threads.show', compact('forumThread'));
    }

    /**
     * Toggle like for a forum thread
     */
    public function toggleLike(ForumThread $forumThread): JsonResponse
    {
        $isLiked = $forumThread->toggleLike();

        return response()->json([
            'liked' => $isLiked,
            'likes_count' => $forumThread->likes_count,
        ]);
    }

    /**
     * Get popular threads
     */
    public function popular(Request $request): \Illuminate\View\View
    {
        $type = $request->get('type', 'likes'); // 'likes' or 'views'
        $limit = $request->get('limit', 10);

        if ($type === 'views') {
            $threads = $this->statsService->getPopularThreadsByViews($limit);
        } else {
            $threads = $this->statsService->getPopularThreadsByLikes($limit);
        }

        return view('forum.threads.popular', compact('threads', 'type'));
    }

    /**
     * Get user's liked threads
     */
    public function userLiked(): \Illuminate\View\View
    {
        $userId = Auth::id();
        $threads = $this->statsService->getUserLikedThreads($userId);

        return view('forum.threads.user-liked', compact('threads'));
    }

    /**
     * Get user's viewed threads
     */
    public function userViewed(): \Illuminate\View\View
    {
        $userId = Auth::id();
        $threads = $this->statsService->getUserViewedThreads($userId);

        return view('forum.threads.user-viewed', compact('threads'));
    }

    /**
     * Get thread statistics
     */
    public function stats(ForumThread $forumThread, Request $request): JsonResponse
    {
        $days = $request->get('days', 30);

        $viewStats = $this->statsService->getThreadDailyStats($forumThread->id, $days);
        $likeStats = $this->statsService->getThreadLikeStats($forumThread->id, $days);

        return response()->json([
            'views' => $viewStats,
            'likes' => $likeStats,
            'total_views' => $forumThread->views_count,
            'total_likes' => $forumThread->likes_count,
        ]);
    }
}
