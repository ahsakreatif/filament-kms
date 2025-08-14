<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kirschbaum\Commentions\Events\CommentWasCreatedEvent;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use App\Filament\Resources\ForumThreadResource;

class CommentWasCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentWasCreatedEvent $event): void
    {
        Log::info('CommentWasCreatedNotification listener called', [
            'comment_id' => $event->comment->id,
            'commentable_type' => get_class($event->comment->commentable),
        ]);

        try {
            $comment = $event->comment;
            $commentable = $comment->commentable;
            $commentAuthor = $comment->author;

            // Only handle forum thread comments
            if (!$commentable instanceof \App\Models\ForumThread) {
                return;
            }

            // Get the thread owner
            $threadOwner = $commentable->user;

            // Don't send notification if the comment author is the thread owner
            if ($commentAuthor->id === $threadOwner->id) {
                return;
            }

            // Don't send notification if there's no thread owner
            if (!$threadOwner) {
                return;
            }

            // Send the notification to the thread owner
            $threadOwner->notify(
                Notification::make()
                    ->title('New reply to your forum thread')
                    ->body("{$commentAuthor->name} replied to your thread: {$commentable->title}")
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->actions([
                        NotificationAction::make('view')
                            ->label('View Thread')
                            ->url(fn () => ForumThreadResource::getUrl('view', ['record' => $commentable->id]))
                            ->color('primary')
                            ->icon('heroicon-o-eye'),
                    ])
                    ->toDatabase(),
            );

        } catch (\Exception $e) {
            Log::error('Failed to send comment created notification', [
                'error' => $e->getMessage(),
                'comment_id' => $event->comment->id,
                'commentable_id' => $event->comment->commentable_id,
                'commentable_type' => $event->comment->commentable_type,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
