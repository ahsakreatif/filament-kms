# Commentions Notification System

## Overview

This document describes the implementation of notifications for the Commentions plugin, specifically for when users are mentioned in comments.

## Implementation Details

### 1. Notification Class

**File**: `app/Notifications/UserMentionedInCommentNotification.php`

This notification class handles the creation and formatting of notifications when users are mentioned in comments.

#### Key Features:
- **Database Storage**: Notifications are stored in the database for persistence
- **Rich Data Structure**: Includes comprehensive information about the comment, commentable object, and users involved
- **Email Support**: Includes email notification formatting (though currently only database is used)
- **Queue Support**: Implements `ShouldQueue` for background processing

#### Data Structure:
```php
[
    'id' => $comment->id,
    'title' => 'You were mentioned in a comment',
    'message' => "John Doe mentioned you in a comment on Forum Thread: Thread Title",
    'comment_id' => $comment->id,
    'comment_body' => 'Comment preview...',
    'commentable_type' => 'Forum Thread',
    'commentable_title' => 'Thread Title',
    'action_url' => 'Proper Filament URL',
    'icon' => 'heroicon-o-at-symbol',
    'color' => 'info',
    'format' => 'filament',
    'mentioned_by_user_id' => $user->id,
    'mentioned_by_user_name' => $user->name,
    'mentioned_by_user_email' => $user->email,
    'comment_created_at' => $comment->created_at,
    'comment_updated_at' => $comment->updated_at,
    'commentable_id' => $comment->commentable_id,
    'commentable_type_class' => get_class($comment->commentable),
]
```

### 2. Event Listener

**File**: `app/Listeners/SendUserMentionedNotification.php`

This listener handles the `UserWasMentionedEvent` dispatched by Commentions when a user is mentioned.

#### Key Features:
- **Self-Mention Prevention**: Prevents notifications when users mention themselves
- **Error Handling**: Comprehensive error handling with logging
- **Queue Support**: Implements `ShouldQueue` for background processing
- **Logging**: Detailed logging for debugging and monitoring

### 3. Event Service Provider

**File**: `app/Providers/EventServiceProvider.php`

Registers the event listener to handle Commentions events.

#### Registration:
```php
protected $listen = [
    UserWasMentionedEvent::class => [
        SendUserMentionedNotification::class,
    ],
];
```

### 4. UI Components

#### Notification Display

**Files**: 
- `resources/views/filament/pages/custom-notifications.blade.php`
- `resources/views/filament/widgets/custom-notification-widget.blade.php`

Both components have been updated to display comment mention notifications with:
- **Distinct Styling**: Blue-themed styling to distinguish from thread notifications
- **Comment Preview**: Shows the comment content
- **Context Information**: Displays what was commented on and who mentioned the user
- **Timestamps**: Shows when the comment was created

#### Visual Design:
- **Blue Theme**: Uses blue colors to distinguish comment mentions from other notifications
- **Comment Box**: Displays the actual comment content in a styled box
- **Icons**: Uses appropriate icons (at-symbol, chat bubble, etc.)
- **Responsive**: Works well in both full page and widget contexts

## Usage

### Automatic Notifications

Notifications are automatically sent when:
1. A user mentions another user in a comment using the `@username` format
2. The mentioned user is not the same as the comment author
3. The mentioned user exists in the system

### Testing

Use the test command to verify the notification system:

```bash
# Test with default values
php artisan test:comment-mention 1

# Test with specific thread and commenter
php artisan test:comment-mention 1 --thread_id=2 --commenter_id=3
```

### Manual Testing

1. **Create a Forum Thread**: Navigate to a forum thread
2. **Add a Comment**: Use the Commentions component to add a comment
3. **Mention a User**: Use `@username` format to mention another user
4. **Check Notifications**: The mentioned user should receive a notification

## Configuration

### Commentions Configuration

The system uses the default Commentions configuration. Key settings in `config/commentions.php`:

```php
'commenter' => [
    'model' => \App\Models\User::class,
],
'comment' => [
    'model' => \Kirschbaum\Commentions\Comment::class,
    'policy' => \Kirschbaum\Commentions\Policies\CommentPolicy::class,
],
```

### Notification Channels

Currently configured to use database storage only. To enable email notifications, modify the `via()` method in the notification class:

```php
public function via(object $notifiable): array
{
    return ['database', 'mail'];
}
```

## Troubleshooting

### Common Issues

1. **Notifications Not Sending**:
   - Check that the EventServiceProvider is registered in `bootstrap/providers.php`
   - Verify that the User model implements the `Notifiable` trait
   - Check application logs for errors

2. **Event Listener Not Firing**:
   - Ensure the `UserWasMentionedEvent` is being dispatched
   - Check that the event listener is properly registered
   - Verify queue workers are running if using queues

3. **UI Not Displaying Notifications**:
   - Check that notification data structure matches expected format
   - Verify that the notification components are properly included
   - Check for JavaScript errors in browser console

### Debugging

1. **Enable Logging**: The event listener includes comprehensive logging
2. **Test Command**: Use the test command to verify functionality
3. **Database Check**: Verify notifications are being stored in the database
4. **Event Testing**: Manually trigger the event to test the listener

## Future Enhancements

### Potential Improvements

1. **Email Notifications**: Enable email notifications for immediate alerts
2. **Push Notifications**: Add real-time push notifications
3. **Notification Preferences**: Allow users to configure notification preferences
4. **Bulk Operations**: Add bulk notification management
5. **Advanced Filtering**: Add filtering and search for notifications
6. **Notification Templates**: Create customizable notification templates

### Integration Opportunities

1. **Real-time Updates**: Integrate with WebSockets for real-time notifications
2. **Mobile App**: Extend to mobile application notifications
3. **External Services**: Integrate with external notification services (Slack, Discord, etc.)
4. **Analytics**: Add notification analytics and reporting

## Security Considerations

1. **User Privacy**: Ensure notifications don't expose sensitive information
2. **Rate Limiting**: Implement rate limiting for notification sending
3. **Access Control**: Verify users can only receive notifications for content they have access to
4. **Data Validation**: Validate all notification data before processing

## Performance Considerations

1. **Queue Processing**: Use queues for background notification processing
2. **Database Indexing**: Ensure proper indexing on notification tables
3. **Caching**: Consider caching frequently accessed notification data
4. **Batch Processing**: Process notifications in batches for better performance
