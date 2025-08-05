<?php

namespace App\Services;

use App\Models\User;
use App\Models\ForumThread;
use App\Models\Document;
use App\Models\UserTagPreference;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RecommendationService
{
    // Points for different interactions
    const LIKE_POINTS = 10;
    const VIEW_POINTS = 1;
    const DECAY_FACTOR = 0.95; // Score decays by 5% per day

    /**
     * Update user preferences when they like a forum thread
     */
    public function recordLike(User $user, ForumThread $forumThread): void
    {
        $this->updateUserPreferences($user, $forumThread, self::LIKE_POINTS, 'like');
    }

    /**
     * Update user preferences when they view a forum thread
     */
    public function recordView(User $user, $model): void
    {
        $this->updateUserPreferences($user, $model, self::VIEW_POINTS, 'view');
    }

    /**
     * Update user preferences when they download a document
     */
    public function recordDownload(User $user, Document $document): void
    {
        $this->updateUserPreferences($user, $document, self::VIEW_POINTS, 'view');
    }

    /**
     * Update user preferences when they favorite a document
     */
    public function recordFavorite(User $user, Document $document): void
    {
        $this->updateUserPreferences($user, $document, self::LIKE_POINTS, 'like');
    }

    /**
     * Update user preferences based on interaction
     */
    private function updateUserPreferences(User $user, $model, int $points, string $interactionType): void
    {
        $tags = $model->tags;

        if ($tags->isEmpty()) {
            return;
        }

        foreach ($tags as $tag) {
            $preference = UserTagPreference::firstOrCreate([
                'user_id' => $user->id,
                'tag_id' => $tag->id,
            ]);

            // Apply decay to existing scores
            $this->applyDecay($preference);

            // Update scores based on interaction type
            if ($interactionType === 'like') {
                $preference->like_score += $points;
            } else {
                $preference->view_score += $points;
            }

            // Calculate total score (likes weighted more heavily)
            $preference->total_score = ($preference->like_score * 2) + $preference->view_score;
            $preference->last_interaction_at = now();
            $preference->save();
        }
    }

    /**
     * Apply time decay to preference scores
     */
    private function applyDecay(UserTagPreference $preference): void
    {
        if (!$preference->last_interaction_at) {
            return;
        }

        $daysSinceLastInteraction = now()->diffInDays($preference->last_interaction_at);

        if ($daysSinceLastInteraction > 0) {
            $decayMultiplier = pow(self::DECAY_FACTOR, $daysSinceLastInteraction);

            $preference->like_score *= $decayMultiplier;
            $preference->view_score *= $decayMultiplier;
        }
    }

    /**
     * Get recommended forum threads for a user
     */
    public function getRecommendedThreads(User $user, int $limit = 10): Collection
    {
        // Get user's top tag preferences
        $topPreferences = UserTagPreference::where('user_id', $user->id)
            ->orderBy('total_score', 'desc')
            ->limit(5)
            ->pluck('tag_id');

        if ($topPreferences->isEmpty()) {
            // If no preferences, return recent popular threads
            return ForumThread::with(['tags', 'user', 'category'])
                ->orderBy('likes_count', 'desc')
                ->orderBy('views_count', 'desc')
                ->limit($limit)
                ->get();
        }

        // Get threads with user's preferred tags
        $recommendedThreads = ForumThread::with(['tags', 'user', 'category'])
            ->whereHas('tags', function ($query) use ($topPreferences) {
                $query->whereIn('tags.id', $topPreferences);
            })
            ->where('user_id', '!=', $user->id) // Exclude user's own threads
            ->orderBy('likes_count', 'desc')
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();

        // If not enough threads, add some popular threads
        if ($recommendedThreads->count() < $limit) {
            $additionalThreads = ForumThread::with(['tags', 'user', 'category'])
                ->whereNotIn('id', $recommendedThreads->pluck('id'))
                ->where('user_id', '!=', $user->id)
                ->orderBy('likes_count', 'desc')
                ->orderBy('views_count', 'desc')
                ->limit($limit - $recommendedThreads->count())
                ->get();

            $recommendedThreads = $recommendedThreads->merge($additionalThreads);
        }

        return $recommendedThreads;
    }

    /**
     * Get recommended documents for a user
     */
    public function getRecommendedDocuments(User $user, int $limit = 10): Collection
    {
        // Get user's top tag preferences
        $topPreferences = UserTagPreference::where('user_id', $user->id)
            ->orderBy('total_score', 'desc')
            ->limit(5)
            ->pluck('tag_id');

        if ($topPreferences->isEmpty()) {
            // If no preferences, return recent popular documents
            return Document::with(['tags', 'category', 'uploadedBy'])
                ->orderBy('favorites_count', 'desc')
                ->orderBy('downloads_count', 'desc')
                ->limit($limit)
                ->get();
        }

        // Get documents with user's preferred tags
        $recommendedDocuments = Document::with(['tags', 'category', 'uploadedBy'])
            ->whereHas('tags', function ($query) use ($topPreferences) {
                $query->whereIn('tags.id', $topPreferences);
            })
            ->where('uploaded_by', '!=', $user->id) // Exclude user's own documents
            ->orderBy('favorites_count', 'desc')
            ->orderBy('downloads_count', 'desc')
            ->limit($limit)
            ->get();

        // If not enough documents, add some popular documents
        if ($recommendedDocuments->count() < $limit) {
            $additionalDocuments = Document::with(['tags', 'category', 'uploadedBy'])
                ->whereNotIn('id', $recommendedDocuments->pluck('id'))
                ->where('uploaded_by', '!=', $user->id)
                ->orderBy('favorites_count', 'desc')
                ->orderBy('downloads_count', 'desc')
                ->limit($limit - $recommendedDocuments->count())
                ->get();

            $recommendedDocuments = $recommendedDocuments->merge($additionalDocuments);
        }

        return $recommendedDocuments;
    }

    /**
     * Get user's top preferred tags
     */
    public function getUserTopTags(User $user, int $limit = 5): Collection
    {
        return UserTagPreference::with('tag')
            ->where('user_id', $user->id)
            ->orderBy('total_score', 'desc')
            ->limit($limit)
            ->get()
            ->pluck('tag');
    }

    /**
     * Get similar users based on tag preferences
     */
    public function getSimilarUsers(User $user, int $limit = 5): Collection
    {
        $userPreferences = UserTagPreference::where('user_id', $user->id)
            ->pluck('tag_id');

        if ($userPreferences->isEmpty()) {
            return collect();
        }

        return UserTagPreference::whereIn('tag_id', $userPreferences)
            ->where('user_id', '!=', $user->id)
            ->select('user_id', DB::raw('SUM(total_score) as similarity_score'))
            ->groupBy('user_id')
            ->orderBy('similarity_score', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return User::find($item->user_id);
            })
            ->filter();
    }

    /**
     * Clean up old preferences (optional maintenance method)
     */
    public function cleanupOldPreferences(int $daysOld = 365): void
    {
        UserTagPreference::where('last_interaction_at', '<', now()->subDays($daysOld))
            ->where('total_score', '<', 0.1)
            ->delete();
    }
}
