# Knowledge Management System (KMS)

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/Filament-3.x-blue.svg" alt="Filament Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-green.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License">
</p>

## 📚 About KMS

The Knowledge Management System (KMS) is a comprehensive academic knowledge sharing platform built with **Laravel 12** and **FilamentPHP 3**. It facilitates document management, collaborative learning, and knowledge sharing among university stakeholders including administrators, lecturers, students, and academic staff.

## ✨ Key Features

### 🔐 Multi-Role Authentication
- **Admin (Superuser)**: System management and oversight
- **Lecturer (Dosen)**: Primary knowledge contributor
- **Student (Mahasiswa)**: Active user accessing resources
- **Academic Staff (Akademik)**: Academic unit administration

### 📄 Document Management
- Upload and manage academic documents (PDF, DOC, DOCX, PPT, etc.)
- Version control and document history
- Advanced search and filtering capabilities
- Download tracking and analytics
- Document approval workflow
- **Document Favorites System**: Users can favorite documents and receive notifications
- **Document Likes & Downloads**: Track user engagement with documents
- **Document Statistics**: Comprehensive analytics for views, downloads, and favorites

### 🏷️ Tag & Category System
- Hierarchical category structure
- Tag-based classification
- Advanced search and filtering
- Tag analytics and usage statistics

### 💬 Forum System
- Topic creation and management
- Thread-based discussions
- User reputation system
- Content moderation tools
- Search and filtering capabilities
- **Forum Thread Statistics**: Track likes, views, and engagement metrics
- **Thread Reply Notifications**: Automatic notifications for thread owners when someone replies
- **User Mention Notifications**: Notify users when mentioned in forum comments
- **Thread Like Notifications**: Notify thread owners when their threads are liked

### 🤖 AI-Powered Recommendations
- Intelligent content suggestions
- Personalized document recommendations
- Forum topic recommendations based on user interests
- **User Activity Tracking**: Monitor user engagement for better recommendations
- **Most Active User Analytics**: Track and display user activity scores

### 📊 Analytics & Statistics
- System usage dashboard
- Document upload statistics
- Forum activity tracking
- User engagement metrics
- **Most Active User Widget**: Display users with highest activity scores
- **Enhanced Forum Statistics**: Detailed analytics for thread performance
- **Document Performance Metrics**: Track document popularity and usage

### 🔔 Advanced Notification System
- **Real-time Notifications**: Database and broadcast notifications
- **Forum Reply Notifications**: Automatic alerts for thread owners
- **User Mention Notifications**: Notify users when mentioned in comments
- **Document Favorite Notifications**: Alert document owners when their content is favorited
- **Thread Like Notifications**: Notify thread owners of new likes
- **Comprehensive Notification UI**: Rich notification display with action buttons

### 👤 User Profile Management
- **Profile Editing**: Users can edit their profiles and personal information
- **Avatar Management**: Upload and manage user avatars with fallback to initials
- **User Type Integration**: Seamless integration with user roles and permissions
- **Profile Statistics**: Display user activity and engagement metrics

### 🎯 Enhanced User Experience
- **Improved UX for Resources**: Better interface for categories, tags, and forum resources
- **Default Sorting**: Automatic sorting by creation date (newest first)
- **Enhanced Form Validation**: Better input validation and error handling
- **Responsive Design**: Optimized for various screen sizes and devices

## 🚀 Technology Stack

- **Backend**: Laravel 12.x
- **Admin Panel**: FilamentPHP 3.x
- **Database**: MySQL/PostgreSQL
- **Frontend**: Blade templates with Alpine.js
- **Authentication**: Laravel's built-in auth with role-based access
- **File Management**: Laravel Storage
- **Search**: Laravel Scout (configurable)
- **Testing**: Pest PHP
- **Notifications**: Filament Notifications with database and broadcast support
- **Comments**: Kirschbaum Commentions plugin
- **Profile Management**: Filament Edit Profile plugin

## 📋 Requirements

- PHP 8.2 or higher
- Composer 2.x
- Node.js 18+ and NPM
- MySQL 8.0+ or PostgreSQL 13+
- Web server (Apache/Nginx)

## 🛠️ Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd kms
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   ```bash
   # Edit .env file with your database credentials
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kms_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## 👥 User Roles & Permissions

### Admin (Superuser)
- System configuration and management
- User role management
- Content moderation
- System analytics and statistics
- Tag and category management
- Document approval and publishing

### Lecturer (Dosen)
- Document upload and management
- Forum participation
- Access to teaching materials
- AI-powered content recommendations
- Profile and avatar management

### Student (Mahasiswa)
- Document access and download
- Forum participation
- Personalized content recommendations
- Study material access
- Document favoriting and engagement tracking

### Academic Staff (Akademik)
- Academic document validation
- Thesis and proposal access
- Administrative document management
- User activity monitoring

## 📁 Project Structure

```
kms/
├── app/
│   ├── Filament/           # FilamentPHP admin panel
│   │   ├── Resources/      # CRUD resources
│   │   ├── Widgets/        # Dashboard widgets
│   │   └── Pages/          # Custom pages
│   ├── Models/             # Eloquent models
│   ├── Services/           # Business logic
│   ├── Listeners/          # Event listeners for notifications
│   ├── Notifications/      # Notification classes
│   └── Traits/             # Reusable traits
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── docs/                  # Documentation
├── resources/
│   └── views/             # Blade templates
└── routes/                # Application routes
```

## 🔧 Configuration

### Key Configuration Files
- `.env` - Environment variables
- `config/filament.php` - FilamentPHP configuration
- `config/auth.php` - Authentication settings
- `config/filesystems.php` - File storage settings
- `config/filament-edit-profile.php` - Profile management settings

### Important Environment Variables
```env
APP_NAME="Knowledge Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kms_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

FILESYSTEM_DISK=public
BROADCAST_DRIVER=database
QUEUE_CONNECTION=database
```

## 🧪 Testing

Run the test suite using Pest:
```bash
php artisan test
```

### Testing Notifications
Test the notification system with built-in commands:
```bash
# Test thread like notifications
php artisan test:notification {user_id} --thread_id={thread_id}

# Test comment mention notifications
php artisan test:comment-mention {user_id} --thread_id={thread_id} --commenter_id={commenter_id}

# Test comment created notifications
php artisan test:comment-created-notification {thread_id} --commenter_id={commenter_id}
```

## 📚 Documentation

- [Complete KMS Documentation](docs/KMS_Documentation.md)
- [Forum Thread Statistics](docs/forum-thread-statistics.md)
- [Student Import/Export Guide](docs/student-import-export.md)
- [Recommendation System](docs/RECOMMENDATION_SYSTEM.md)
- [Notification System Improvements](docs/notification-system-improvements.md)
- [Commentions Notification System](docs/commentions-notification-system.md)
- [Forum Thread Reply Notifications](docs/forum-thread-reply-notifications.md)

## 🔔 Notification System

The KMS includes a comprehensive notification system with the following features:

### Types of Notifications
- **Forum Thread Replies**: Notify thread owners when someone replies
- **User Mentions**: Alert users when mentioned in comments using @username
- **Document Favorites**: Notify document owners when their content is favorited
- **Thread Likes**: Alert thread owners when their threads receive likes

### Notification Channels
- **Database Notifications**: Persistent notifications stored in database
- **Broadcast Notifications**: Real-time notifications via broadcasting
- **Filament UI Integration**: Rich notification display with action buttons

### Configuration
Notifications are automatically sent based on user interactions and can be configured through the EventServiceProvider.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Check the [documentation](docs/)
- Contact the development team

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP framework
- [FilamentPHP](https://filamentphp.com) - The admin panel
- [Spatie Laravel Permission](https://github.com/spatie/laravel-permission) - Role and permission management
- [Kirschbaum Commentions](https://github.com/kirschbaum-development/commentions) - Commenting system
- [Filament Edit Profile](https://github.com/joaopaulolndev/filament-edit-profile) - Profile management

---

<p align="center">Built with ❤️ for academic institutions</p>
