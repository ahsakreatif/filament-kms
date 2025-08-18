<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ForumThread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_forum::thread');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ForumThread $forumThread): bool
    {
        return $user->can('view_forum::thread');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_forum::thread');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ForumThread $forumThread): bool
    {
        return $user->id === $forumThread->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ForumThread $forumThread): bool
    {
        return $user->id === $forumThread->user_id;
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        // Prevent bulk deletion to ensure users cannot remove threads they do not own
        return false;
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, ForumThread $forumThread): bool
    {
        return $user->id === $forumThread->user_id;
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, ForumThread $forumThread): bool
    {
        return $user->can('restore_forum::thread');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_forum::thread');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, ForumThread $forumThread): bool
    {
        return $user->can('replicate_forum::thread');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_forum::thread');
    }
}
