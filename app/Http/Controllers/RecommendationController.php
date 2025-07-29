<?php

namespace App\Http\Controllers;

use App\Services\RecommendationService;
use App\Models\UserTagPreference;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class RecommendationController extends BaseController
{
    protected RecommendationService $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
        $this->middleware('auth');
    }

    /**
     * Get recommended forum threads for the authenticated user
     */
    public function getRecommendedThreads(Request $request): JsonResponse
    {
        $user = Auth::user();
        $limit = $request->get('limit', 10);

        $recommendedThreads = $this->recommendationService->getRecommendedThreads($user, $limit);

        return response()->json([
            'success' => true,
            'data' => $recommendedThreads,
            'message' => 'Recommended threads retrieved successfully'
        ]);
    }

    /**
     * Get user's top preferred tags
     */
    public function getUserTopTags(Request $request): JsonResponse
    {
        $user = Auth::user();
        $limit = $request->get('limit', 5);

        $topTags = $this->recommendationService->getUserTopTags($user, $limit);

        return response()->json([
            'success' => true,
            'data' => $topTags,
            'message' => 'User top tags retrieved successfully'
        ]);
    }

    /**
     * Get similar users based on tag preferences
     */
    public function getSimilarUsers(Request $request): JsonResponse
    {
        $user = Auth::user();
        $limit = $request->get('limit', 5);

        $similarUsers = $this->recommendationService->getSimilarUsers($user, $limit);

        return response()->json([
            'success' => true,
            'data' => $similarUsers,
            'message' => 'Similar users retrieved successfully'
        ]);
    }

        /**
     * Get user's tag preference statistics
     */
    public function getUserPreferences(): JsonResponse
    {
        $user = Auth::user();

        $preferences = UserTagPreference::where('user_id', $user->id)
            ->with('tag')
            ->orderBy('total_score', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $preferences,
            'message' => 'User preferences retrieved successfully'
        ]);
    }
}
