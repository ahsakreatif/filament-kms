# Forum Thread Statistics

This document describes the forum thread like and view statistics feature implemented for the KMS system.

## Overview

The forum thread statistics system provides:
- **View tracking**: Records when users view forum threads
- **Like system**: Allows users to like/unlike forum threads
- **Statistics**: Provides various methods to analyze thread popularity

## Database Structure

### Tables Created

1. **`forum_thread_views`** - Tracks individual views
   - `forum_thread_id` - Foreign key to forum_threads
   - `user_id` - Foreign key to users (nullable for anonymous views)
   - `ip_address` - IP address of the viewer
   - `user_agent` - Browser/device information
   - `viewed_at` - Timestamp of the view

2. **`forum_thread_likes`** - Tracks user likes
   - `forum_thread_id` - Foreign key to forum_threads
   - `user_id` - Foreign key to users
   - `liked_at` - Timestamp of the like
   - Unique constraint on `(forum_thread_id, user_id)` to prevent duplicate likes

3. **`forum_threads`** - Denormalized count columns added
   - `likes_count` - Total number of likes (denormalized)
   - `views_count` - Total number of views (denormalized)
   - `unique_views_count` - Total number of unique views by user (denormalized)

## Models

### ForumThreadView
```php
// Record a view
$thread->recordView();

// Get view count
$viewCount = $thread->views_count;

// Get unique view count
$uniqueViews = $thread->unique_views_count;
```

### ForumThreadLike
```php
// Toggle like
$isLiked = $thread->toggleLike();

// Check if current user liked
$isLiked = $thread->isLikedByCurrentUser();

// Get like count
$likeCount = $thread->likes_count;
```

### ForumThread
The ForumThread model now includes:
- `views()` - HasMany relationship to ForumThreadView
- `likes()` - HasMany relationship to ForumThreadLike
- `likedBy()` - BelongsToMany relationship to User
- `viewedBy()` - BelongsToMany relationship to User

## Usage Examples

### Recording Views
```php
// In a controller
public function show(ForumThread $thread)
{
    $thread->recordView(); // Automatically records view with user info
    return view('thread.show', compact('thread'));
}
```

### Handling Likes
```php
// Toggle like via AJAX
public function toggleLike(ForumThread $thread)
{
    $isLiked = $thread->toggleLike();
    
    return response()->json([
        'liked' => $isLiked,
        'likes_count' => $thread->likes_count,
    ]);
}
```

### Getting Statistics
```php
// Using the service
$statsService = app(ForumThreadStatsService::class);

// Popular threads by likes
$popularByLikes = $statsService->getPopularThreadsByLikes(10);

// Popular threads by views
$popularByViews = $statsService->getPopularThreadsByViews(10);

// User's liked threads
$userLiked = $statsService->getUserLikedThreads($userId);

// Daily statistics
$dailyStats = $statsService->getThreadDailyStats($threadId, 30);
```

## Features

### View Tracking
- Automatically records IP address and user agent
- Prevents duplicate views from the same user within 24 hours
- Supports anonymous views (user_id can be null)

### Like System
- One like per user per thread (enforced by unique constraint)
- Toggle functionality (like/unlike)
- Real-time like count updates

### Statistics
- Total view count
- Unique view count (by user)
- Total like count
- Daily statistics for views and likes
- Popular threads by likes or views
- User's liked and viewed threads

## Performance Considerations

- Indexes are added on frequently queried columns
- View tracking includes a 24-hour cooldown to prevent spam
- Like system uses unique constraints to prevent duplicates
- Statistics queries are optimized with proper indexing
- **Denormalized counts** for improved performance:
  - `likes_count` - Updated automatically when likes are added/removed
  - `views_count` - Updated automatically when views are recorded
  - `unique_views_count` - Updated automatically for new unique users
  - Eliminates expensive `COUNT()` queries for display

## Migration

Run the migrations to create the necessary tables:

```bash
php artisan migrate
```

This will create:
- `forum_thread_views` table
- `forum_thread_likes` table
- Denormalized count columns in `forum_threads` table
- Appropriate indexes and foreign key constraints

## Populate Existing Data

After running migrations, populate counts for existing data:

```bash
# Populate all threads
php artisan forum:populate-counts

# Populate specific thread
php artisan forum:populate-counts --thread-id=1
```

## API Endpoints

Example routes you might want to add:

```php
Route::get('/forum/threads/{thread}/like', [ForumThreadController::class, 'toggleLike']);
Route::get('/forum/threads/popular', [ForumThreadController::class, 'popular']);
Route::get('/forum/threads/liked', [ForumThreadController::class, 'userLiked']);
Route::get('/forum/threads/viewed', [ForumThreadController::class, 'userViewed']);
Route::get('/forum/threads/{thread}/stats', [ForumThreadController::class, 'stats']);
``` 
