<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ForumThread;
use Kirschbaum\Commentions\Events\UserWasMentionedEvent;
use Kirschbaum\Commentions\Comment;

class TestCommentionsEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:commentions-event {user_id} {--thread_id=1} {--commenter_id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the Commentions UserWasMentionedEvent with the event listener';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $threadId = $this->option('thread_id');
        $commenterId = $this->option('commenter_id');

        $user = User::find($userId);
        if (!$user) {
            $this->error("User with ID {$userId} not found!");
            return 1;
        }

        $thread = ForumThread::find($threadId);
        if (!$thread) {
            $this->error("Forum thread with ID {$threadId} not found!");
            return 1;
        }

        $commenter = User::find($commenterId);
        if (!$commenter) {
            $this->error("Commenter with ID {$commenterId} not found!");
            return 1;
        }

        $this->info("Testing Commentions event for user: {$user->name} ({$user->email})");
        $this->info("Thread: {$thread->title}");
        $this->info("Commenter: {$commenter->name}");

        try {
            // Create a mock comment for testing
            $mockComment = new Comment([
                'id' => 999999,
                'body' => 'This is a test comment mentioning @' . $user->name . ' to test the event system.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Set the commentable relationship
            $mockComment->commentable = $thread;
            $mockComment->author = $commenter;

            // Get initial notification count
            $initialCount = $user->notifications()->count();
            $this->info("Initial notification count: {$initialCount}");

            // Dispatch the event
            $event = new UserWasMentionedEvent($mockComment, $user);
            event($event);

            $this->info('✅ Commentions event dispatched successfully!');

            // Check if notification was created
            $finalCount = $user->notifications()->count();
            $this->info("Final notification count: {$finalCount}");

            if ($finalCount > $initialCount) {
                $this->info('✅ Event listener worked! Notification was created.');

                // Show the latest notification details
                $latestNotification = $user->notifications()->latest()->first();
                if ($latestNotification) {
                    $this->info('Latest notification details:');
                    $this->info('- Type: ' . $latestNotification->type);
                    $this->info('- Title: ' . ($latestNotification->data['title'] ?? 'N/A'));
                    $this->info('- Message: ' . ($latestNotification->data['message'] ?? 'N/A'));
                    $this->info('- Comment Body: ' . ($latestNotification->data['comment_body'] ?? 'N/A'));
                    $this->info('- Commentable Type: ' . ($latestNotification->data['commentable_type'] ?? 'N/A'));
                    $this->info('- Commentable Title: ' . ($latestNotification->data['commentable_title'] ?? 'N/A'));
                    $this->info('- Mentioned By: ' . ($latestNotification->data['mentioned_by_user_name'] ?? 'N/A'));
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
