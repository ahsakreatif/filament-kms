<?php

namespace App\Console\Commands;

use App\Models\ForumThread;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateForumThreadCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forum:populate-counts {--thread-id= : Specific thread ID to update}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate denormalized like and view counts for forum threads';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threadId = $this->option('thread-id');

        if ($threadId) {
            $this->updateThreadCounts($threadId);
        } else {
            $this->updateAllThreadCounts();
        }

        $this->info('Forum thread counts updated successfully!');
    }

    /**
     * Update counts for all threads
     */
    protected function updateAllThreadCounts(): void
    {
        $this->info('Updating counts for all forum threads...');

        $threads = ForumThread::all();
        $bar = $this->output->createProgressBar($threads->count());

        foreach ($threads as $thread) {
            $this->updateThreadCounts($thread->id, false);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }

    /**
     * Update counts for a specific thread
     */
    protected function updateThreadCounts(int $threadId, bool $showInfo = true): void
    {
        $thread = ForumThread::find($threadId);

        if (!$thread) {
            $this->error("Thread with ID {$threadId} not found.");
            return;
        }

        if ($showInfo) {
            $this->info("Updating counts for thread: {$thread->title}");
        }

        // Update likes count
        $likesCount = $thread->likes()->count();
        $thread->likes_count = $likesCount;

        // Update views count
        $viewsCount = $thread->views()->count();
        $thread->views_count = $viewsCount;

        // Update unique views count
        $uniqueViewsCount = $thread->views()->distinct('user_id')->count('user_id');
        $thread->unique_views_count = $uniqueViewsCount;

        $thread->save();

        if ($showInfo) {
            $this->info("Updated: {$likesCount} likes, {$viewsCount} views, {$uniqueViewsCount} unique views");
        }
    }
}
