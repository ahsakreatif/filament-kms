<?php

namespace Database\Seeders;

use App\Models\ForumThread;
use App\Models\ForumTopic;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserTagPreference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ForumThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we already have data
        $existingTopics = ForumTopic::count();
        $existingCategories = Category::count();
        $existingTags = Tag::count();
        $existingThreads = ForumThread::count();

        if ($existingThreads > 0) {
            $this->command->info('Forum threads already exist. Skipping seeder.');
            return;
        }

        // Create forum topics if they don't exist
        if ($existingTopics === 0) {
            $topics = [
                'Laravel Development' => 'Discussions about Laravel framework development, best practices, and tips.',
                'PHP Programming' => 'General PHP programming discussions, language features, and development tips.',
                'Frontend Development' => 'Discussions about HTML, CSS, JavaScript, and frontend frameworks.',
                'Database Design' => 'Database design, optimization, and management discussions.',
                'DevOps & Deployment' => 'Discussions about deployment, server management, and DevOps practices.',
                'Testing & Quality Assurance' => 'Testing strategies, tools, and quality assurance practices.',
                'Security' => 'Web application security, best practices, and vulnerability discussions.',
                'Performance Optimization' => 'Application performance, caching, and optimization techniques.',
                'API Development' => 'RESTful APIs, GraphQL, and API design discussions.',
                'Mobile Development' => 'Mobile app development with web technologies.',
            ];

            foreach ($topics as $name => $description) {
                ForumTopic::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $description,
                    'thumbnail' => fake()->imageUrl(400, 300, 'technology', true),
                ]);
            }
        }

        // Create categories if they don't exist
        if ($existingCategories === 0) {
            $categories = [
                'Programming' => 'General programming discussions and tutorials',
                'Web Development' => 'Web development topics and discussions',
                'Mobile Development' => 'Mobile app development discussions',
                'Database' => 'Database design, optimization, and management',
                'DevOps' => 'DevOps practices, deployment, and infrastructure',
                'Design' => 'UI/UX design and frontend development',
                'Testing' => 'Testing strategies and quality assurance',
                'Security' => 'Application security and best practices',
                'Performance' => 'Performance optimization and monitoring',
                'Tools' => 'Development tools and utilities',
            ];

            foreach ($categories as $name => $description) {
                Category::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $description,
                    'parent_id' => null,
                    'icon' => 'fas fa-code',
                    'color' => fake()->randomElement(['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6']),
                    'is_active' => true,
                    'sort_order' => rand(1, 100),
                ]);
            }
        }

        // Create popular tags if they don't exist
        if ($existingTags === 0) {
            $popularTags = [
                'Laravel' => 'Laravel framework discussions and tutorials',
                'PHP' => 'PHP programming language discussions',
                'JavaScript' => 'JavaScript programming and frameworks',
                'Vue.js' => 'Vue.js framework discussions',
                'React' => 'React library discussions',
                'Angular' => 'Angular framework discussions',
                'Node.js' => 'Node.js runtime environment',
                'MySQL' => 'MySQL database discussions',
                'PostgreSQL' => 'PostgreSQL database discussions',
                'MongoDB' => 'MongoDB NoSQL database',
                'Redis' => 'Redis caching and data store',
                'Docker' => 'Docker containerization',
                'AWS' => 'Amazon Web Services',
                'Git' => 'Version control with Git',
                'GitHub' => 'GitHub platform discussions',
                'CI/CD' => 'Continuous Integration and Deployment',
                'Testing' => 'Software testing strategies',
                'API' => 'Application Programming Interfaces',
                'REST' => 'RESTful API design',
                'Security' => 'Application security',
                'Performance' => 'Application performance optimization',
                'Caching' => 'Caching strategies and techniques',
                'Mobile' => 'Mobile application development',
                'TypeScript' => 'TypeScript programming language',
                'Python' => 'Python programming language',
            ];

            foreach ($popularTags as $name => $description) {
                Tag::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $description,
                    'color' => fake()->randomElement(['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4', '#F97316', '#EC4899', '#84CC16', '#6366F1']),
                    'usage_count' => rand(10, 100),
                ]);
            }
        }

        // Create users if they don't exist
        $users = User::factory()->count(20)->create();

        // Create forum threads with realistic data
        $threadTitles = [
            'How to implement authentication in Laravel?',
            'Best practices for database optimization',
            'Understanding Eloquent relationships',
            'Setting up a new Laravel project',
            'Working with Blade templates',
            'API development with Laravel',
            'Testing strategies for web applications',
            'Deployment strategies for Laravel apps',
            'Performance optimization techniques',
            'Security best practices in web development',
            'Working with queues and jobs',
            'Understanding middleware in Laravel',
            'File upload handling in Laravel',
            'Caching strategies for better performance',
            'Working with third-party APIs',
            'Database migration best practices',
            'User management and authorization',
            'Error handling and logging',
            'Frontend integration with Laravel',
            'Docker setup for Laravel applications',
            'Vue.js integration with Laravel',
            'React integration with Laravel',
            'Building RESTful APIs',
            'GraphQL implementation in Laravel',
            'Real-time features with Laravel Echo',
            'Payment integration with Stripe',
            'Email handling with Laravel Mail',
            'File storage with Laravel Storage',
            'Search functionality with Laravel Scout',
            'Queue management and job processing',
        ];

        $threadBodies = [
            'I\'m trying to implement user authentication in my Laravel application. Can anyone share their experience with the best practices for setting up authentication? I\'ve been using the built-in authentication scaffolding, but I need some custom features.',

            'Our application is experiencing slow database queries. I\'ve been looking into optimization techniques like indexing and query optimization. Does anyone have experience with database performance tuning in Laravel?',

            'I\'m new to Laravel and trying to understand how Eloquent relationships work. Can someone explain the different types of relationships (hasOne, hasMany, belongsTo, belongsToMany) with practical examples?',

            'I\'m starting a new Laravel project and want to make sure I\'m following the best practices from the beginning. What are the essential packages and configurations you recommend for a new project?',

            'I\'m working with Blade templates and need to create reusable components. What are the best practices for organizing Blade templates and creating custom components?',

            'I\'m building an API with Laravel and need to implement proper authentication and authorization. What are the recommended approaches for API development in Laravel?',

            'I want to implement comprehensive testing for my Laravel application. What testing strategies do you recommend? Should I focus on unit tests, feature tests, or both?',

            'I\'m ready to deploy my Laravel application to production. What deployment strategies do you recommend? I\'m considering using Laravel Forge or Vapor.',

            'My Laravel application is getting slower as it grows. What performance optimization techniques have you found most effective? I\'m particularly interested in caching strategies.',

            'I\'m concerned about security in my web application. What are the most important security practices I should implement in my Laravel application?',
        ];

        $tags = Tag::all();
        $topics = ForumTopic::all();
        $categories = Category::all();

        // Create forum threads
        foreach ($threadTitles as $index => $title) {
            $thread = ForumThread::create([
                'title' => $title,
                'body' => $threadBodies[$index % count($threadBodies)],
                'forum_topic_id' => $topics->random()->id,
                'category_id' => $categories->random()->id,
                'user_id' => $users->random()->id,
                'likes_count' => rand(0, 50),
                'views_count' => rand(0, 200),
                'unique_views_count' => rand(0, 100),
            ]);

            // Attach 1-4 random tags to each thread
            $threadTags = $tags->random(rand(1, 4));
            $thread->tags()->syncWithoutDetaching($threadTags);

            // Create some user interactions for recommendation system
            if (rand(1, 3) === 1) {
                $randomUsers = $users->random(rand(1, 5));
                foreach ($randomUsers as $user) {
                    // Create user preferences based on thread tags
                    foreach ($threadTags as $tag) {
                        UserTagPreference::updateOrCreate(
                            [
                                'user_id' => $user->id,
                                'tag_id' => $tag->id,
                            ],
                            [
                                'like_score' => rand(5, 20),
                                'view_score' => rand(10, 50),
                                'total_score' => rand(20, 100),
                                'last_interaction_at' => now()->subDays(rand(0, 30)),
                            ]
                        );
                    }
                }
            }
        }

        // Create some popular threads
        ForumThread::factory()
            ->count(10)
            ->popular()
            ->create()
            ->each(function ($thread) use ($tags, $users) {
                $thread->tags()->syncWithoutDetaching($tags->random(rand(1, 3)));

                // Create user preferences for popular threads
                $randomUsers = $users->random(rand(3, 8));
                foreach ($randomUsers as $user) {
                    foreach ($thread->tags as $tag) {
                        UserTagPreference::updateOrCreate(
                            [
                                'user_id' => $user->id,
                                'tag_id' => $tag->id,
                            ],
                            [
                                'like_score' => rand(15, 40),
                                'view_score' => rand(20, 80),
                                'total_score' => rand(50, 150),
                                'last_interaction_at' => now()->subDays(rand(0, 7)),
                            ]
                        );
                    }
                }
            });

        // Create some fresh threads
        ForumThread::factory()
            ->count(15)
            ->fresh()
            ->create()
            ->each(function ($thread) use ($tags) {
                $thread->tags()->syncWithoutDetaching($tags->random(rand(1, 2)));
            });

        // Create some controversial threads
        ForumThread::factory()
            ->count(5)
            ->controversial()
            ->create()
            ->each(function ($thread) use ($tags, $users) {
                $thread->tags()->syncWithoutDetaching($tags->random(rand(1, 4)));

                // Create mixed user preferences for controversial threads
                $randomUsers = $users->random(rand(5, 10));
                foreach ($randomUsers as $user) {
                    foreach ($thread->tags as $tag) {
                        UserTagPreference::updateOrCreate(
                            [
                                'user_id' => $user->id,
                                'tag_id' => $tag->id,
                            ],
                            [
                                'like_score' => rand(0, 10),
                                'view_score' => rand(30, 100),
                                'total_score' => rand(30, 120),
                                'last_interaction_at' => now()->subDays(rand(0, 14)),
                            ]
                        );
                    }
                }
            });

        $this->command->info('Forum threads seeded successfully!');
        $this->command->info('Created ' . ForumThread::count() . ' forum threads');
        $this->command->info('Created ' . UserTagPreference::count() . ' user tag preferences');
    }
}
