<?php

namespace App\Filament\Widgets;

use App\Models\ForumThread;
use App\Services\ForumThreadStatsService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ForumThreadStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $statsService = app(ForumThreadStatsService::class);

        $totalThreads = ForumThread::count();
        $totalLikes = ForumThread::sum('likes_count');
        $totalViews = ForumThread::sum('views_count');

        $popularThreads = $statsService->getPopularThreadsByLikes(1);
        $mostLikedThread = $popularThreads->first();

        $popularViews = $statsService->getPopularThreadsByViews(1);
        $mostViewedThread = $popularViews->first();

        return [
            Stat::make('Total Threads', $totalThreads)
                ->description('All forum threads')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('primary'),

            Stat::make('Total Likes', $totalLikes)
                ->description('Across all threads')
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger'),

            Stat::make('Total Views', $totalViews)
                ->description('Across all threads')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),

            Stat::make('Most Liked Thread', $mostLikedThread ? $mostLikedThread->title : 'N/A')
                ->description($mostLikedThread ? "by {$mostLikedThread->user->name} ({$mostLikedThread->likes_count} likes)" : 'No threads yet')
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger'),

            Stat::make('Most Viewed Thread', $mostViewedThread ? $mostViewedThread->title : 'N/A')
                ->description($mostViewedThread ? "by {$mostViewedThread->user->name} ({$mostViewedThread->views_count} views)" : 'No threads yet')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),
        ];
    }
}
