# Recommendation System Documentation

## Overview

The recommendation system tracks user interactions with forum threads and builds user preferences based on forum thread tags. When users like or view forum threads, the system records their preferences and uses this data to recommend similar content.

## Key Features

- **Automatic Preference Tracking**: Records user preferences when they like or view forum threads
- **Tag-Based Recommendations**: Uses forum thread tags to build user interest profiles
- **Weighted Scoring**: Likes are weighted more heavily than views (10 points vs 1 point)
- **Time Decay**: Preferences decay over time to keep recommendations fresh
- **Similar User Discovery**: Find users with similar interests
- **Admin Dashboard Widget**: View recommendations directly in the Filament admin panel

## How It Works

### 1. User Interaction Tracking

When a user interacts with a forum thread:

- **Like**: Adds 10 points to the like_score for each tag on the thread
- **View**: Adds 1 point to the view_score for each tag on the thread
- **Total Score**: Calculated as `(like_score * 2) + view_score`

### 2. Time Decay

Preferences decay by 5% per day to ensure recommendations stay relevant:

```php
$decayMultiplier = pow(0.95, $daysSinceLastInteraction);
```

### 3. Recommendation Algorithm

1. Get user's top 5 preferred tags
2. Find forum threads with those tags
3. Exclude user's own threads
4. Order by popularity (likes + views)
5. Fill remaining slots with popular threads if needed

## Database Schema

### UserTagPreference Table

```sql
CREATE TABLE user_tag_preferences (
    id BIGINT PRIMARY KEY,
    user_id BIGINT REFERENCES users(id),
    tag_id BIGINT REFERENCES tags(id),
    like_score DECIMAL(8,4) DEFAULT 0,
    view_score DECIMAL(8,4) DEFAULT 0,
    total_score DECIMAL(8,4) DEFAULT 0,
    last_interaction_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(user_id, tag_id)
);
```

## API Endpoints

### Get Recommended Threads
```
GET /api/recommendations/threads?limit=10
```

### Get User's Top Tags
```
GET /api/recommendations/top-tags?limit=5
```

### Get Similar Users
```
GET /api/recommendations/similar-users?limit=5
```

### Get User Preferences
```
GET /api/recommendations/preferences
```

## Usage Examples

### In Controllers

```php
use App\Services\RecommendationService;

class ForumController extends Controller
{
    public function show(ForumThread $thread, RecommendationService $recommendationService)
    {
        // Record view
        $recommendationService->recordView(auth()->user(), $thread);
        
        // Get recommendations
        $recommendations = $recommendationService->getRecommendedThreads(auth()->user());
        
        return view('forum.show', compact('thread', 'recommendations'));
    }
}
```

### In Blade Templates

```php
@foreach($recommendations as $thread)
    <div class="recommended-thread">
        <h3>{{ $thread->title }}</h3>
        <p>by {{ $thread->user->name }}</p>
        <div class="tags">
            @foreach($thread->tags as $tag)
                <span class="tag">{{ $tag->name }}</span>
            @endforeach
        </div>
    </div>
@endforeach
```

## Admin Dashboard

The recommendation system includes a Filament widget that displays:

- User's top interest tags
- Recommended forum threads
- Interaction statistics

The widget is automatically included in the admin dashboard.

## Maintenance

### Cleanup Command

Periodically clean up old preferences:

```bash
php artisan recommendations:cleanup --days=365
```

This removes preferences older than 365 days with low scores.

### Scheduled Cleanup

Add to your `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule): void
{
    $schedule->command('recommendations:cleanup')->monthly();
}
```

## Configuration

### Scoring Weights

You can adjust the scoring weights in `RecommendationService`:

```php
const LIKE_POINTS = 10;    // Points for liking a thread
const VIEW_POINTS = 1;     // Points for viewing a thread
const DECAY_FACTOR = 0.95; // Daily decay factor
```

### Recommendation Limits

Adjust the number of recommendations and tags:

```php
$recommendations = $recommendationService->getRecommendedThreads($user, 15);
$topTags = $recommendationService->getUserTopTags($user, 10);
```

## Testing

Run the recommendation system tests:

```bash
php artisan test tests/Feature/RecommendationServiceTest.php
```

## Performance Considerations

- The system uses database indexes for efficient queries
- Preferences are cached and updated incrementally
- Time decay is calculated on-demand to save storage
- Consider adding Redis caching for high-traffic applications

## Future Enhancements

- Collaborative filtering algorithms
- Content-based filtering improvements
- Machine learning integration
- Real-time recommendation updates
- A/B testing framework 
