<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\ThreadLikedNotification;
use App\Models\ForumThread;

class TestNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notification {user_id} {--thread_id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test notification to a specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $threadId = $this->option('thread_id');

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

        $this->info("Sending test notification to user: {$user->name} ({$user->email})");
        $this->info("Thread: {$thread->title}");

        try {
            $user->notify(new ThreadLikedNotification($thread, true));
            $this->info('✅ Test notification sent successfully!');

            // Show current notification count
            $notificationCount = $user->notifications()->count();
            $this->info("User now has {$notificationCount} total notifications");

        } catch (\Exception $e) {
            $this->error('❌ Failed to send notification: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
