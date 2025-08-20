# Knowledge Management System (KMS) - Complete Documentation
## Built with FilamentPHP

---

## 📋 Table of Contents
1. [Requirements](#requirements)
2. [Product Requirements Document (PRD)](#product-requirements-document-prd)
3. [Entity Relationship Diagram (ERD)](#entity-relationship-diagram-erd)
4. [Database Schema](#database-schema)
5. [Implementation Guide](#implementation-guide)

---

## 📝 Requirements

### User Roles & Activities

#### 1. Admin (Superuser)
**Responsibilities:** Overall system management and oversight

**Activities:**
- **System Login:** Access as superuser
- **Tag & Category Management:** Configure document tags for classification and search
- **Activity Statistics:** Access system usage dashboard (uploads, forum activity, active users)
- **Content Moderation:** Delete, hide, or flag content violating campus rules or ethics

#### 2. Dosen (Lecturer)
**Responsibilities:** Primary knowledge contributor

**Activities:**
- **System Login:** Access KMS using institutional account
- **Document Upload:** Upload teaching materials, articles, research proposals, and other academic content
- **AI Content Recommendations:** Receive suggestions for relevant documents or forum topics
- **Forum Discussions:** Create or respond to academic discussion topics
- **Document Access:** View and download available repository documents

#### 3. Mahasiswa (Student)
**Responsibilities:** Active user accessing and utilizing knowledge resources

**Activities:**
- **System Login:** Access system with institutional account
- **Document Access:** Access teaching materials, articles, and thesis documents
- **Forum Discussions:** Ask questions, discuss, and learn through academic forums
- **AI Content Recommendations:** Receive document suggestions based on study program or access history

#### 4. Akademik (Academic Staff)
**Responsibilities:** Academic unit or faculty administration related to formal student documents

**Activities:**
- **System Login:** Access using academic account
- **Document Access:** Access thesis, proposals, and academic reports
- **Academic Document Validation:** Verify completeness and authenticity of academic documents uploaded by lecturers

---

## 📋 Product Requirements Document (PRD)

### 1. Executive Summary
A comprehensive Knowledge Management System built with FilamentPHP to facilitate academic knowledge sharing, document management, and collaborative learning among university stakeholders including administrators, lecturers, students, and academic staff.

### 2. Product Overview

#### 2.1 Product Vision
To create a centralized, intelligent knowledge repository that enhances academic collaboration, streamlines document management, and promotes knowledge sharing across the university ecosystem.

#### 2.2 Product Goals
- Centralize academic document management
- Facilitate collaborative learning through forums
- Provide AI-powered content recommendations
- Ensure secure access control and content moderation
- Streamline academic document validation processes

### 3. Functional Requirements

#### 3.1 Authentication & Authorization
- Multi-role authentication system
- Institutional credential integration
- Role-based access control (RBAC)
- Session management and security

#### 3.2 Document Management
- Document upload with metadata
- File format support (PDF, DOC, DOCX, PPT, etc.)
- Version control and document history
- Search and filtering capabilities
- Download tracking and analytics

#### 3.3 Tag & Category System
- Hierarchical category structure
- Tag-based classification
- Advanced search and filtering
- Tag analytics and usage statistics

#### 3.4 Forum System
- Topic creation and management
- Thread-based discussions
- User reputation system
- Content moderation tools
- Search and filtering

#### 3.5 AI Recommendation Engine
- Content-based recommendations
- User behavior analysis
- Study program-based suggestions
- Collaborative filtering

#### 3.6 Content Moderation
- Flag inappropriate content
- Review queue management
- Content approval workflows
- Automated content filtering

#### 3.7 Analytics & Reporting
- User activity tracking
- Document access statistics
- Forum engagement metrics
- System usage analytics

### 4. Non-Functional Requirements

#### 4.1 Performance
- Page load time < 3 seconds
- Support for concurrent users (1000+)
- Efficient search functionality
- Optimized file storage and retrieval

#### 4.2 Security
- Data encryption at rest and in transit
- Regular security audits
- GDPR compliance
- Secure file upload validation

#### 4.3 Scalability
- Horizontal scaling capability
- Database optimization
- CDN integration for file delivery
- Caching strategies

#### 4.4 Usability
- Intuitive user interface
- Mobile-responsive design
- Accessibility compliance (WCAG 2.1)
- Multi-language support

### 5. Technical Architecture

#### 5.1 Technology Stack
- **Backend:** Laravel 10+ with FilamentPHP 3.x
- **Frontend:** FilamentPHP Admin Panel + Blade Templates
- **Database:** MySQL 8.0+ / PostgreSQL 13+
- **File Storage:** Local/Cloud storage (AWS S3, DigitalOcean Spaces)
- **Search:** Laravel Scout with Meilisearch/Algolia
- **Queue:** Redis for background jobs
- **Cache:** Redis for application caching

#### 5.2 Key FilamentPHP Features
- Resource management for all entities
- Custom dashboard widgets
- Advanced form components
- File upload handling
- Role-based permissions
- Custom actions and bulk operations

### 6. Implementation Phases

#### Phase 1: Core Foundation (Weeks 1-4)
- User authentication and authorization
- Basic document management
- Category and tag system
- Admin dashboard

#### Phase 2: Forum & Collaboration (Weeks 5-8)
- Forum system implementation
- User interaction features
- Basic moderation tools

#### Phase 3: AI & Analytics (Weeks 9-12)
- Recommendation engine
- Analytics and reporting
- Advanced search features

#### Phase 4: Optimization & Testing (Weeks 13-16)
- Performance optimization
- Security hardening
- User acceptance testing
- Deployment preparation

### 7. Success Metrics
- User adoption rate (>80% within 6 months)
- Document upload frequency (target: 100+ documents/month)
- Forum engagement (target: 500+ posts/month)
- System uptime (>99.5%)
- User satisfaction score (>4.0/5.0)

---

## 🗄️ Entity Relationship Diagram (ERD)

### Database Schema Design

#### 1. Core User Management Tables

##### 1.1 users (Simplified Core Table)
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    avatar VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_login_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

##### 1.2 user_types (Configuration Table)
```sql
CREATE TABLE user_types (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,           -- 'student', 'lecturer', 'academic_staff', 'admin'
    display_name VARCHAR(255) NOT NULL,         -- 'Student', 'Lecturer', 'Academic Staff', 'Administrator'
    description TEXT NULL,
    profile_table VARCHAR(255) NOT NULL,        -- Which profile table to use
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

##### 1.3 user_type_assignments (Mapping Table)
```sql
CREATE TABLE user_type_assignments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    user_type_id BIGINT UNSIGNED NOT NULL,
    profile_id BIGINT UNSIGNED NOT NULL,        -- ID from the specific profile table
    is_primary BOOLEAN DEFAULT FALSE,           -- User can have multiple types, but one primary
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    assigned_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_type (user_id, user_type_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user_type_id) REFERENCES user_types(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL
);
```

#### 2. User Profile Tables

##### 2.1 student_profiles
```sql
CREATE TABLE student_profiles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    student_id VARCHAR(50) UNIQUE NOT NULL,
    study_program VARCHAR(255) NOT NULL,
    faculty VARCHAR(255) NOT NULL,
    enrollment_year INT NOT NULL,
    current_semester INT NOT NULL,
    gpa DECIMAL(3,2) NULL,
    advisor_id BIGINT UNSIGNED NULL,            -- References lecturer_profiles
    status ENUM('active', 'graduated', 'suspended', 'dropped') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (advisor_id) REFERENCES lecturer_profiles(id) ON DELETE SET NULL
);
```

##### 2.2 lecturer_profiles
```sql
CREATE TABLE lecturer_profiles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    lecturer_id VARCHAR(50) UNIQUE NOT NULL,
    faculty VARCHAR(255) NOT NULL,
    specialization VARCHAR(255) NULL,
    academic_rank ENUM('assistant', 'lecturer', 'associate_professor', 'professor') NOT NULL,
    qualification VARCHAR(255) NULL,            -- PhD, Master, etc.
    research_interests TEXT NULL,
    office_location VARCHAR(255) NULL,
    office_hours TEXT NULL,
    status ENUM('active', 'inactive', 'retired') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

##### 2.3 academic_staff_profiles
```sql
CREATE TABLE academic_staff_profiles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    academic_id VARCHAR(50) UNIQUE NOT NULL,
    faculty VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,             -- Head of Department, Dean, etc.
    office_location VARCHAR(255) NULL,
    responsibilities TEXT NULL,
    status ENUM('active', 'inactive', 'retired') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

##### 2.4 admin_profiles
```sql
CREATE TABLE admin_profiles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    admin_id VARCHAR(50) UNIQUE NOT NULL,
    position VARCHAR(255) NOT NULL,             -- System Admin, Content Moderator, etc.
    access_level ENUM('super_admin', 'admin', 'moderator') NOT NULL,
    permissions JSON NULL,                      -- Additional specific permissions
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### 3. Document Management Tables

##### 3.1 categories
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    parent_id BIGINT UNSIGNED NULL,             -- For hierarchical structure
    icon VARCHAR(100) NULL,
    color VARCHAR(7) NULL,                      -- Hex color code
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);
```

##### 3.2 tags
```sql
CREATE TABLE tags (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    color VARCHAR(7) NULL,
    usage_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

##### 3.3 documents
```sql
CREATE TABLE documents (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(500) NOT NULL,
    slug VARCHAR(500) UNIQUE NOT NULL,
    description TEXT NULL,
    abstract TEXT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_size BIGINT NOT NULL,
    file_type VARCHAR(100) NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    uploaded_by BIGINT UNSIGNED NOT NULL,
    author VARCHAR(255) NULL,
    keywords TEXT NULL,
    publication_year INT NULL,
    doi VARCHAR(255) NULL,
    isbn VARCHAR(50) NULL,
    language VARCHAR(10) DEFAULT 'id',
    is_public BOOLEAN DEFAULT TRUE,
    is_featured BOOLEAN DEFAULT FALSE,
    downloads_count INT DEFAULT 0,
    view_count INT DEFAULT 0,
    status ENUM('draft', 'published', 'archived', 'flagged') DEFAULT 'published',
    approved_by BIGINT UNSIGNED NULL,
    approved_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
);
```

##### 3.4 document_tag (Pivot Table)
```sql
CREATE TABLE document_tag (
    document_id BIGINT UNSIGNED,
    tag_id BIGINT UNSIGNED,
    PRIMARY KEY (document_id, tag_id),
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);
```

##### 3.5 document_downloads
```sql
CREATE TABLE document_downloads (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    document_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULL,               -- NULL for anonymous downloads
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    downloaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

##### 3.6 document_views
```sql
CREATE TABLE document_views (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    document_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

#### 4. Forum System Tables

##### 4.1 forum_categories
```sql
CREATE TABLE forum_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    icon VARCHAR(100) NULL,
    color VARCHAR(7) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

##### 4.2 forum_topics
```sql
CREATE TABLE forum_topics (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(500) NOT NULL,
    slug VARCHAR(500) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    is_pinned BOOLEAN DEFAULT FALSE,
    is_locked BOOLEAN DEFAULT FALSE,
    is_featured BOOLEAN DEFAULT FALSE,
    view_count INT DEFAULT 0,
    reply_count INT DEFAULT 0,
    last_reply_at TIMESTAMP NULL,
    last_reply_by BIGINT UNSIGNED NULL,
    status ENUM('active', 'closed', 'flagged') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES forum_categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (last_reply_by) REFERENCES users(id) ON DELETE SET NULL
);
```

##### 4.3 forum_posts
```sql
CREATE TABLE forum_posts (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    topic_id BIGINT UNSIGNED NOT NULL,
    content TEXT NOT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED NULL,             -- For nested replies
    is_solution BOOLEAN DEFAULT FALSE,          -- Mark as best answer
    like_count INT DEFAULT 0,
    dislike_count INT DEFAULT 0,
    status ENUM('active', 'flagged', 'deleted') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (topic_id) REFERENCES forum_topics(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (parent_id) REFERENCES forum_posts(id) ON DELETE CASCADE
);
```

##### 4.4 forum_post_reactions
```sql
CREATE TABLE forum_post_reactions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    post_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    reaction_type ENUM('like', 'dislike', 'love', 'helpful') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_post_reaction (user_id, post_id, reaction_type),
    FOREIGN KEY (post_id) REFERENCES forum_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### 5. Content Moderation Tables

##### 5.1 content_flags
```sql
CREATE TABLE content_flags (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    flaggable_type VARCHAR(255) NOT NULL,       -- 'App\Models\Document' or 'App\Models\ForumPost'
    flaggable_id BIGINT UNSIGNED NOT NULL,
    flagged_by BIGINT UNSIGNED NOT NULL,
    reason ENUM('inappropriate', 'spam', 'copyright', 'duplicate', 'other') NOT NULL,
    description TEXT NULL,
    status ENUM('pending', 'reviewed', 'resolved', 'dismissed') DEFAULT 'pending',
    reviewed_by BIGINT UNSIGNED NULL,
    reviewed_at TIMESTAMP NULL,
    resolution_notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (flagged_by) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
);
```

#### 6. Analytics & Activity Tracking Tables

##### 6.1 user_activities
```sql
CREATE TABLE user_activities (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    activity_type VARCHAR(100) NOT NULL,        -- 'login', 'upload', 'download', 'forum_post', etc.
    subject_type VARCHAR(255) NULL,             -- Model class name
    subject_id BIGINT UNSIGNED NULL,            -- Model ID
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    metadata JSON NULL,                         -- Additional activity data
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

##### 6.2 system_statistics
```sql
CREATE TABLE system_statistics (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    stat_date DATE NOT NULL,
    stat_type VARCHAR(100) NOT NULL,            -- 'daily_uploads', 'daily_downloads', 'active_users', etc.
    stat_value INT NOT NULL,
    metadata JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_date_type (stat_date, stat_type)
);
```

#### 7. AI Recommendation Tables

##### 7.1 user_preferences
```sql
CREATE TABLE user_preferences (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    preference_key VARCHAR(255) NOT NULL,
    preference_value TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_preference (user_id, preference_key),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

##### 7.2 content_recommendations
```sql
CREATE TABLE content_recommendations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    recommended_type VARCHAR(255) NOT NULL,     -- 'document', 'forum_topic'
    recommended_id BIGINT UNSIGNED NOT NULL,
    recommendation_score DECIMAL(5,4) NOT NULL,
    recommendation_reason VARCHAR(255) NULL,
    is_viewed BOOLEAN DEFAULT FALSE,
    is_clicked BOOLEAN DEFAULT FALSE,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### 8. Notification System Tables

##### 8.1 notifications
```sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    type VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    data JSON NULL,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### 9. Settings & Configuration Tables

##### 9.1 system_settings
```sql
CREATE TABLE system_settings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(255) UNIQUE NOT NULL,
    setting_value TEXT NOT NULL,
    setting_type ENUM('string', 'integer', 'boolean', 'json') DEFAULT 'string',
    description TEXT NULL,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Key Relationships Summary

#### One-to-Many Relationships:
- User → Documents (uploaded_by)
- User → Forum Topics (created_by)
- User → Forum Posts (created_by)
- Category → Documents
- Forum Category → Forum Topics
- Forum Topic → Forum Posts
- Document → Document Downloads
- Document → Document Views

#### Many-to-Many Relationships:
- Users ↔ User Types (via user_type_assignments)
- Documents ↔ Tags (via document_tag)

#### One-to-One Relationships:
- User ↔ Student Profile
- User ↔ Lecturer Profile
- User ↔ Academic Staff Profile
- User ↔ Admin Profile

#### Self-Referencing Relationships:
- Categories → Categories (parent_id for hierarchical structure)
- Forum Posts → Forum Posts (parent_id for nested replies)

### Performance Indexes

```sql
-- Document search optimization
CREATE INDEX idx_documents_title ON documents(title);
CREATE INDEX idx_documents_status ON documents(status);
CREATE INDEX idx_documents_uploaded_by ON documents(uploaded_by);
CREATE INDEX idx_documents_category_id ON documents(category_id);

-- Forum optimization
CREATE INDEX idx_forum_topics_category_id ON forum_topics(category_id);
CREATE INDEX idx_forum_topics_created_by ON forum_topics(created_by);
CREATE INDEX idx_forum_posts_topic_id ON forum_posts(topic_id);

-- Activity tracking
CREATE INDEX idx_user_activities_user_id ON user_activities(user_id);
CREATE INDEX idx_user_activities_created_at ON user_activities(created_at);

-- Search optimization
CREATE FULLTEXT INDEX ft_documents_title_description ON documents(title, description);
CREATE FULLTEXT INDEX ft_forum_topics_title_content ON forum_topics(title, content);
```

---

## 🚀 Implementation Guide

### FilamentPHP Resource Mapping

#### Admin Resources:
1. **UserResource** - Manage users, roles, and permissions
2. **UserTypeResource** - Manage user types configuration
3. **StudentProfileResource** - Manage student profiles
4. **LecturerProfileResource** - Manage lecturer profiles
5. **AcademicStaffProfileResource** - Manage academic staff profiles
6. **AdminProfileResource** - Manage admin profiles
7. **CategoryResource** - Manage document categories
8. **TagResource** - Manage document tags
9. **DocumentResource** - Manage documents with approval workflow
10. **ForumCategoryResource** - Manage forum categories
11. **ForumTopicResource** - Moderate forum topics
12. **ContentFlagResource** - Handle content moderation
13. **SystemSettingResource** - Configure system settings
14. **StatisticsResource** - View analytics and reports

#### User Resources:
1. **DocumentResource** - Upload and manage own documents
2. **ForumTopicResource** - Create and manage forum topics
3. **ProfileResource** - Manage user profile and preferences

### Laravel Model Structure

```php
// User.php
class User extends Authenticatable
{
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }
    
    public function lecturerProfile()
    {
        return $this->hasOne(LecturerProfile::class);
    }
    
    public function academicStaffProfile()
    {
        return $this->hasOne(AcademicStaffProfile::class);
    }
    
    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class);
    }
    
    public function userTypes()
    {
        return $this->belongsToMany(UserType::class, 'user_type_assignments');
    }
    
    public function getPrimaryTypeAttribute()
    {
        return $this->userTypes()->wherePivot('is_primary', true)->first();
    }
}
```

### Sample Data Setup

```sql
-- User Types Configuration
INSERT INTO user_types (name, display_name, description, profile_table) VALUES
('student', 'Student', 'University students who can access learning materials', 'student_profiles'),
('lecturer', 'Lecturer', 'Academic staff who can upload and manage documents', 'lecturer_profiles'),
('academic_staff', 'Academic Staff', 'Administrative staff for academic affairs', 'academic_staff_profiles'),
('admin', 'Administrator', 'System administrators with full access', 'admin_profiles');
```

### Migration Strategy

#### Phase 1: Create New Tables
1. Create `user_types` table
2. Create profile tables (`student_profiles`, `lecturer_profiles`, etc.)
3. Create `user_type_assignments` table
4. Create all other system tables

#### Phase 2: Data Migration
1. Migrate existing data from old structure to new profile tables
2. Create user type assignments
3. Update foreign key references

#### Phase 3: Clean Up
1. Remove old fields from `users` table
2. Update application code to use new structure
3. Test all functionality

---

## 📊 Benefits of This Design

### ✅ **Advantages:**
1. **Proper Normalization**: Each profile table contains only relevant data
2. **Data Integrity**: No NULL fields for irrelevant data
3. **Extensibility**: Easy to add new user types
4. **Flexibility**: Users can have multiple roles/types
5. **Performance**: Smaller, focused tables
6. **Maintainability**: Clear separation of concerns

### 🔧 **Implementation Benefits:**
1. **Laravel Polymorphic Relationships**: Easy to implement
2. **FilamentPHP Resources**: Clean, focused resources for each profile type
3. **Validation**: Type-specific validation rules
4. **Queries**: Simpler, more efficient queries

This comprehensive documentation provides everything needed to build your Knowledge Management System with FilamentPHP! 
