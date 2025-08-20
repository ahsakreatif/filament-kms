<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ForumThread;
use Kirschbaum\Commentions\Events\CommentWasCreatedEvent;
use Kirschbaum\Commentions\Comment;

class TestCommentCreatedNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:comment-created-notification {thread_id} {--commenter_id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the CommentWasCreatedEvent with the CommentWasCreatedNotification listener';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threadId = $this->argument('thread_id');
        $commenterId = $this->option('commenter_id');

        $thread = ForumThread::with('user')->find($threadId);
        if (!$thread) {
            $this->error("Forum thread with ID {$threadId} not found!");
            return 1;
        }

        $commenter = User::find($commenterId);
        if (!$commenter) {
            $this->error("Commenter with ID {$commenterId} not found!");
            return 1;
        }

        $threadOwner = $thread->user;
        if (!$threadOwner) {
            $this->error("Thread owner not found for thread ID {$threadId}!");
            return 1;
        }

        $this->info("Testing CommentWasCreatedEvent for thread: {$thread->title}");
        $this->info("Thread Owner: {$threadOwner->name} ({$threadOwner->email})");
        $this->info("Commenter: {$commenter->name} ({$commenter->email})");

        // Don't test if commenter is the thread owner
        if ($commenter->id === $threadOwner->id) {
            $this->warn("Commenter is the same as thread owner. This will not trigger a notification.");
            $this->info("To test properly, use a different commenter ID.");
            return 0;
        }

        try {
            // Create a mock comment for testing
            $mockComment = new Comment([
                'id' => 999999,
                'body' => 'This is a test reply to the forum thread.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Set the commentable relationship
            $mockComment->commentable = $thread;
            $mockComment->author = $commenter;

            // Get initial notification count for thread owner
            $initialCount = $threadOwner->notifications()->count();
            $this->info("Initial notification count for thread owner: {$initialCount}");

            // Dispatch the event
            $event = new CommentWasCreatedEvent($mockComment);
            $this->info('Dispatching CommentWasCreatedEvent...');
            event($event);

            $this->info('✅ CommentWasCreatedEvent dispatched successfully!');

            // Check if notification was created
            $finalCount = $threadOwner->notifications()->count();
            $this->info("Final notification count for thread owner: {$finalCount}");

            if ($finalCount > $initialCount) {
                $this->info('✅ Event listener worked! Notification was created.');

                // Show the latest notification details
                $latestNotification = $threadOwner->notifications()->latest()->first();
                if ($latestNotification) {
                    $this->info('Latest notification details:');
                    $this->info('- Type: ' . $latestNotification->type);
                    $this->info('- Title: ' . ($latestNotification->data['title'] ?? 'N/A'));
                    $this->info('- Body: ' . ($latestNotification->data['body'] ?? 'N/A'));
                    $this->info('- Icon: ' . ($latestNotification->data['icon'] ?? 'N/A'));
                }
            } else {
                $this->warn('⚠️ Event listener may not have worked. No new notification created.');
            }

        } catch (\Exception $e) {
            $this->error('❌ Failed to test event: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }

        return 0;
    }
}
