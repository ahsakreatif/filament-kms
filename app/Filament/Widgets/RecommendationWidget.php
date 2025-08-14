<?php

namespace App\Filament\Widgets;

use App\Models\ForumThread;
use App\Services\RecommendationService;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class RecommendationWidget extends Widget
{
    protected static string $view = 'filament.widgets.recommendation-widget';

    protected int | string | array $columnSpan = 'full';

    public function getRecommendedThreads()
    {
        $user = Auth::user();

        if (!$user->can('view_any_forum::thread')) {
            return collect([]);
        }

        $recommendationService = app(RecommendationService::class);

        return $recommendationService->getRecommendedThreads($user, 5);
    }

    public function getRecommendedDocuments()
    {
        $user = Auth::user();

        if (!$user->can('view_any_document')) {
            return collect([]);
        }

        $recommendationService = app(RecommendationService::class);

        return $recommendationService->getRecommendedDocuments($user, 5);
    }

    public function getUserTopTags()
    {
        $user = Auth::user();
        $recommendationService = app(RecommendationService::class);

        return $recommendationService->getUserTopTags($user, 3);
    }
}
