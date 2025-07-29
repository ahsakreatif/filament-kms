<?php

namespace App\Observers;

use App\Models\ForumThread;
use App\Models\ForumThreadLike;
use App\Models\ForumThreadView;

class ForumThreadObserver
{
    /**
     * Handle the ForumThread "deleted" event.
     */
    public function deleted(ForumThread $forumThread): void
    {
        // Clean up related records
        ForumThreadLike::where('forum_thread_id', $forumThread->id)->delete();
        ForumThreadView::where('forum_thread_id', $forumThread->id)->delete();
    }
}
