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

### 🤖 AI-Powered Recommendations
- Intelligent content suggestions
- Personalized document recommendations
- Forum topic recommendations based on user interests

### 📊 Analytics & Statistics
- System usage dashboard
- Document upload statistics
- Forum activity tracking
- User engagement metrics

## 🚀 Technology Stack

- **Backend**: Laravel 12.x
- **Admin Panel**: FilamentPHP 3.x
- **Database**: MySQL/PostgreSQL
- **Frontend**: Blade templates with Alpine.js
- **Authentication**: Laravel's built-in auth with role-based access
- **File Management**: Laravel Storage
- **Search**: Laravel Scout (configurable)
- **Testing**: Pest PHP

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

### Lecturer (Dosen)
- Document upload and management
- Forum participation
- Access to teaching materials
- AI-powered content recommendations

### Student (Mahasiswa)
- Document access and download
- Forum participation
- Personalized content recommendations
- Study material access

### Academic Staff (Akademik)
- Academic document validation
- Thesis and proposal access
- Administrative document management

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

FILESYSTEM_DISK=local
```

## 🧪 Testing

Run the test suite using Pest:
```bash
php artisan test
```

## 📚 Documentation

- [Complete KMS Documentation](docs/KMS_Documentation.md)
- [Forum Thread Statistics](docs/forum-thread-statistics.md)
- [Student Import/Export Guide](docs/student-import-export.md)
- [Recommendation System](docs/RECOMMENDATION_SYSTEM.md)

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

---

<p align="center">Built with ❤️ for academic institutions</p>
