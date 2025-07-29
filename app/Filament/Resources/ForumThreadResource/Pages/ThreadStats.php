<?php

namespace App\Filament\Resources\ForumThreadResource\Pages;

use App\Filament\Resources\ForumThreadResource;
use App\Models\ForumThread;
use App\Services\ForumThreadStatsService;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ThreadStats extends Page
{
    protected static string $resource = ForumThreadResource::class;

    protected static string $view = 'filament.resources.forum-thread-resource.pages.thread-stats';

    public ForumThread $record;
    public $viewStats = [];
    public $likeStats = [];
    public $popularThreads = [];
    public $userLikedThreads = [];

    public function mount(ForumThread $record): void
    {
        $this->record = $record;
        $this->loadStats();
    }

    protected function loadStats(): void
    {
        $statsService = app(ForumThreadStatsService::class);

        // Load daily statistics
        $this->viewStats = $statsService->getThreadDailyStats($this->record->id, 30);
        $this->likeStats = $statsService->getThreadLikeStats($this->record->id, 30);

        // Load popular threads
        $this->popularThreads = $statsService->getPopularThreadsByLikes(5);

        // Load user's liked threads
        if (Auth::check()) {
            $this->userLikedThreads = $statsService->getUserLikedThreads(Auth::id(), 5);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back_to_thread')
                ->label('Back to Thread')
                ->url(fn () => ForumThreadResource::getUrl('view', ['record' => $this->record]))
                ->color('gray'),
            Action::make('refresh_stats')
                ->label('Refresh Statistics')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $this->loadStats();
                    Notification::make()
                        ->title('Statistics refreshed successfully!')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function toggleLike(): void
    {
        $isLiked = $this->record->toggleLike();
        $message = $isLiked ? 'Thread liked successfully!' : 'Thread unliked successfully!';

        Notification::make()
            ->title($message)
            ->success()
            ->send();
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
