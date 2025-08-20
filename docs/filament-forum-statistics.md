# Forum Thread Statistics in Filament

This document describes how the forum thread like and view statistics are integrated into the Filament admin panel.

## Features Implemented

### 1. Table Columns
- **Likes Column**: Shows total likes with heart icon and red color
- **Views Column**: Shows total views with eye icon and blue color
- Both columns are sortable and toggleable

### 2. Table Actions
- **Like/Unlike Action**: Toggle like status with confirmation modal
- Actions are grouped in a dropdown menu for better UX

### 3. Infolist Statistics
- **Total Likes**: Shows like count with heart icon
- **Total Views**: Shows view count with eye icon
- **Unique Views**: Shows unique view count by user
- **Liked by You**: Shows if current user has liked the thread

### 4. View Page Actions
- **Like/Unlike Button**: Quick like toggle in header
- **View Statistics Button**: Links to detailed statistics page
- **Automatic View Recording**: Views are automatically recorded when users visit threads

### 5. Statistics Page
- **Overview Cards**: Total likes, views, unique views, creation date
- **Quick Actions**: Like/unlike and record view buttons
- **Daily Charts**: Visual representation of views and likes over time
- **Popular Threads**: Shows other popular threads by likes
- **User's Liked Threads**: Shows threads liked by current user

### 6. Dashboard Widget
- **Total Threads**: Count of all forum threads
- **Total Likes**: Sum of all likes across threads
- **Total Views**: Sum of all views across threads
- **Most Liked Thread**: Thread with highest like count
- **Most Viewed Thread**: Thread with highest view count

## Usage

### In Table View
1. **View Statistics**: Click on the likes/views columns to sort by popularity
2. **Like Threads**: Use the action menu to like/unlike threads

### In Thread View
1. **Quick Actions**: Use header buttons for like/unlike
2. **View Statistics**: Click "View Statistics" to see detailed analytics
3. **Statistics Section**: View basic stats in the infolist
4. **Automatic View Recording**: Views are automatically recorded when you visit threads

### In Statistics Page
1. **Overview**: See key metrics at the top
2. **Daily Trends**: View charts showing activity over time
3. **Popular Content**: Discover other popular threads
4. **Your Activity**: See threads you've liked

## Technical Implementation

### Models Used
- `ForumThread` - Main thread model with statistics relationships
- `ForumThreadLike` - Like tracking model
- `ForumThreadView` - View tracking model
- `ForumThreadStatsService` - Service for complex statistics queries

### Key Methods
- `recordView()` - Records a view with IP and user agent
- `toggleLike()` - Toggles like status for current user
- `isLikedByCurrentUser()` - Checks if current user liked the thread
- `likes_count` / `views_count` - Accessor properties for counts

### Database Structure
- `forum_thread_likes` - Stores user likes with unique constraints
- `forum_thread_views` - Stores view records with IP and user agent
- Proper indexing for performance

## Customization

### Adding More Statistics
To add more statistics, extend the `ForumThreadStatsService`:

```php
// Add to ForumThreadStatsService
public function getThreadEngagementRate(int $threadId): float
{
    $thread = ForumThread::find($threadId);
    $totalViews = $thread->views_count;
    $totalLikes = $thread->likes_count;
    
    return $totalViews > 0 ? ($totalLikes / $totalViews) * 100 : 0;
}
```

### Custom Widgets
Create new widgets by extending `StatsOverviewWidget`:

```php
class CustomForumWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Custom Metric', 'Value')
                ->description('Description')
                ->color('success'),
        ];
    }
}
```

### Custom Actions
Add custom actions to the resource:

```php
Action::make('custom_action')
    ->label('Custom Action')
    ->icon('heroicon-o-star')
    ->action(function (ForumThread $record) {
        // Custom logic
    })
```

## Performance Considerations

1. **Eager Loading**: Statistics are loaded efficiently with `withCount()`
2. **Indexing**: Database indexes on frequently queried columns
3. **Caching**: Consider caching for frequently accessed statistics
4. **Pagination**: Large datasets are paginated appropriately

## Security

1. **User Authentication**: All actions require authenticated users
2. **Input Validation**: All inputs are validated and sanitized
3. **CSRF Protection**: All forms include CSRF tokens
4. **Rate Limiting**: Consider implementing rate limiting for like/view actions

## Future Enhancements

1. **Real-time Updates**: WebSocket integration for live statistics
2. **Advanced Analytics**: More detailed charts and metrics
3. **Export Features**: Export statistics to CSV/PDF
4. **Notification System**: Notify users of new likes/views
5. **Trending Algorithm**: More sophisticated popularity calculations 
