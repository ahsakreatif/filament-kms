<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\UserMentionedInCommentNotification;
use Kirschbaum\Commentions\Events\UserWasMentionedEvent;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use App\Filament\Resources\ForumThreadResource;

class SendUserMentionedNotification
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserWasMentionedEvent $event): void
    {
        try {
            // Get the user who was mentioned
            $mentionedUser = $event->user;

            // Get the user who mentioned them (the comment author)
            $mentionedBy = $event->comment->author;

            // Don't send notification if user mentions themselves
            if ($mentionedUser->id === $mentionedBy->id) {
                return;
            }

            // Send the notification
            $mentionedUser->notify(
                Notification::make()
                    ->title('You were mentioned in a comment')
                    ->body("{$mentionedBy->name} mentioned you in a comment on {$event->comment->commentable->title}")
                    ->icon('heroicon-o-at-symbol')
                    ->actions([
                        NotificationAction::make('view')
                            ->label('View Comment')
                            ->url(fn () => ForumThreadResource::getUrl('view', ['record' => $event->comment->commentable->id]))
                            ->color('primary')
                            ->icon('heroicon-o-eye'),
                    ])
                    ->toDatabase(),
            );

            Log::info('User mentioned notification sent', [
                'mentioned_user_id' => $mentionedUser->id,
                'mentioned_by_user_id' => $mentionedBy->id,
                'comment_id' => $event->comment->id,
                'commentable_type' => get_class($event->comment->commentable),
                'commentable_id' => $event->comment->commentable_id,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send user mentioned notification', [
                'error' => $e->getMessage(),
                'comment_id' => $event->comment->id,
                'user_id' => $event->user->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
