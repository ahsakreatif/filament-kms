# Forum Thread Reply Notifications

## Overview

This document describes the implementation of notifications for forum thread owners when someone adds a reply to their forum thread using the Commentions plugin.

## Implementation Details

### 1. Event Listener

**File**: `app/Listeners/CommentWasCreatedNotification.php`

This listener handles the `CommentWasCreatedEvent` dispatched by Commentions when a new comment is created.

#### Key Features:
- **Forum Thread Filtering**: Only processes comments on ForumThread models
- **Self-Reply Prevention**: Prevents notifications when thread owners reply to their own threads
- **Error Handling**: Comprehensive error handling with logging
- **Queue Support**: Implements `ShouldQueue` for background processing
- **Logging**: Detailed logging for debugging and monitoring

#### Logic Flow:
1. Receives `CommentWasCreatedEvent` with the new comment
2. Checks if the commentable is a ForumThread
3. Gets the thread owner from the commentable relationship
4. Prevents notification if comment author is the thread owner
5. Sends notification to thread owner with thread details and action link

### 2. Event Service Provider

**File**: `app/Providers/EventServiceProvider.php`

Registers the event listener to handle Commentions events.

#### Registration:
```php
protected $listen = [
    CommentWasCreatedEvent::class => [
        CommentWasCreatedNotification::class,
    ],
    UserWasMentionedEvent::class => [
        SendUserMentionedNotification::class,
    ],
];
```

### 3. Notification Structure

The notification sent to thread owners includes:
- **Title**: "New reply to your forum thread"
- **Body**: "{Commenter Name} replied to your thread: {Thread Title}"
- **Icon**: `heroicon-o-chat-bubble-left-right`
- **Action**: "View Thread" button that links to the forum thread view page

### 4. Testing Command

**File**: `app/Console/Commands/TestCommentCreatedNotificationCommand.php`

A test command to verify the notification system works correctly.

#### Usage:
```bash
# Test with default commenter (ID 1)
php artisan test:comment-created-notification 1

# Test with specific commenter
php artisan test:comment-created-notification 1 --commenter_id=2
```

## Usage

### Automatic Notifications

Notifications are automatically sent when:
1. A user adds a comment/reply to a forum thread
2. The comment author is not the same as the thread owner
3. The thread has a valid owner
4. The commentable is a ForumThread model

### Manual Testing

1. **Create a Forum Thread**: Navigate to a forum thread
2. **Add a Reply**: Use the Commentions component to add a reply as a different user
3. **Check Notifications**: The thread owner should receive a notification

### Testing with Command

```bash
# Test with thread ID 1 and commenter ID 2
php artisan test:comment-created-notification 1 --commenter_id=2
```

## Configuration

### Event Service Provider Registration

The EventServiceProvider is registered in `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
];
```

### Notification Channels

Currently configured to use database storage only. The notification uses Filament's notification system and is stored in the database.

## Troubleshooting

### Common Issues

1. **Notifications Not Sending**:
   - Check that the EventServiceProvider is registered in `bootstrap/providers.php`
   - Verify that the User model implements the `Notifiable` trait
   - Check application logs for errors
   - Ensure the commentable is a ForumThread model

2. **Event Listener Not Firing**:
   - Ensure the `CommentWasCreatedEvent` is being dispatched
   - Check that the event listener is properly registered
   - Verify queue workers are running if using queues

3. **Self-Reply Notifications**:
   - The system prevents notifications when thread owners reply to their own threads
   - This is intentional behavior to avoid spam

### Debugging

1. **Enable Logging**: The event listener includes comprehensive logging
2. **Test Command**: Use the test command to verify functionality
3. **Database Check**: Verify notifications are being stored in the database
4. **Event Testing**: Manually trigger the event to test the listener

## Integration with Existing Systems

### Commentions Integration

The notification system integrates seamlessly with the existing Commentions plugin:
- Uses the same comment model and relationships
- Leverages existing comment creation events
- Maintains consistency with the mention notification system

### Filament Integration

Notifications are displayed using Filament's notification system:
- Appears in the notification dropdown
- Uses Filament's notification styling
- Includes action buttons for navigation

## Future Enhancements

### Potential Improvements

1. **Email Notifications**: Enable email notifications for immediate alerts
2. **Push Notifications**: Add real-time push notifications
3. **Notification Preferences**: Allow users to configure notification preferences
4. **Batch Notifications**: Group multiple replies into a single notification
5. **Reply Content Preview**: Include a preview of the reply content in the notification

### Configuration Options

Future versions could include:
- Toggle for enabling/disabling reply notifications
- Custom notification messages
- Different notification channels (email, SMS, etc.)
- Notification frequency controls
