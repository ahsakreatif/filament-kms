<?php

namespace App\Filament\Resources\ForumThreadResource\Pages;

use App\Filament\Resources\ForumThreadResource;
use App\Models\ForumThread;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ForumViewThread extends ViewRecord
{
    protected static string $resource = ForumThreadResource::class;

    protected static string $view = 'filament.resources.forum-thread-resource.pages.forum-view-thread';

    public function mount($record): void
    {
        parent::mount($record);

        // Automatically record view when user visits the thread
        $this->record->recordView();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back_to_list')
                ->label('Back to Threads')
                ->url(ForumThreadResource::getUrl())
                ->color('gray'),
            Action::make('edit')
                ->label('Edit Thread')
                ->url(fn () => ForumThreadResource::getUrl('edit', ['record' => $this->record]))
                ->color('primary'),
            Action::make('like')
                ->label(fn (): string => $this->record->isLikedByCurrentUser() ? 'Unlike' : 'Like')
                ->icon(fn (): string => $this->record->isLikedByCurrentUser() ? 'heroicon-o-heart' : 'heroicon-o-heart')
                ->color(fn (): string => $this->record->isLikedByCurrentUser() ? 'danger' : 'gray')
                ->action(function () {
                    $isLiked = $this->record->toggleLike();
                    $message = $isLiked ? 'Thread liked successfully!' : 'Thread unliked successfully!';

                    Notification::make()
                        ->title($message)
                        ->success()
                        ->send();
                }),
            /* Action::make('view_stats')
                ->label('View Statistics')
                ->icon('heroicon-o-chart-bar')
                ->color('success')
                ->url(fn () => ForumThreadResource::getUrl('stats', ['record' => $this->record])), */
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
