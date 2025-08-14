<?php

namespace App\Filament\Resources\ForumThreadResource\Pages;

use App\Filament\Resources\ForumThreadResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Notifications\Notification;
use Filament\Facades\Filament;

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

                    // send notification to thread owner
                    $threadOwner = $this->record->user;
                    $currentUser = Filament::auth()->user();
                    if ($threadOwner && $currentUser && $threadOwner->getKey() !== $currentUser->getKey() && $isLiked) {
                        $title = 'Your thread has been liked!';
                        $body = 'Someone liked your thread "' . $this->record->title . '"';
                        $threadOwner->notify(
                            Notification::make()
                            ->title($title)
                            ->body($body)
                            ->actions([
                                NotificationAction::make('view')
                                    ->label('View Thread')
                                    ->url(fn () => ForumThreadResource::getUrl('view', ['record' => $this->record]))
                                    ->color('primary')
                                    ->icon('heroicon-o-eye'),
                            ])
                            ->icon('heroicon-o-heart')
                            ->toDatabase(),
                        );
                        $threadOwner->notify(
                            Notification::make()
                                ->title($title)
                                ->icon('heroicon-o-heart')
                                ->toBroadcast(),
                        );
                    }
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
