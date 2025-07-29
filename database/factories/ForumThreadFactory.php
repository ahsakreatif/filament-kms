<?php

namespace Database\Factories;

use App\Models\ForumThread;
use App\Models\User;
use App\Models\ForumTopic;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ForumThread>
 */
class ForumThreadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ForumThread::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
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
        ];

        $bodies = [
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

        return [
            'title' => $this->faker->randomElement($titles),
            'body' => $this->faker->randomElement($bodies),
            'forum_topic_id' => ForumTopic::inRandomOrder()->first()?->id ?? ForumTopic::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'likes_count' => $this->faker->numberBetween(0, 50),
            'views_count' => $this->faker->numberBetween(0, 200),
            'unique_views_count' => function (array $attributes) {
                return $this->faker->numberBetween(0, $attributes['views_count']);
            },
        ];
    }

    /**
     * Indicate that the forum thread is popular (high likes and views).
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'likes_count' => $this->faker->numberBetween(20, 100),
            'views_count' => $this->faker->numberBetween(100, 500),
            'unique_views_count' => $this->faker->numberBetween(50, 200),
        ]);
    }

    /**
     * Indicate that the forum thread is new (low likes and views).
     */
    public function fresh(): static
    {
        return $this->state(fn (array $attributes) => [
            'likes_count' => $this->faker->numberBetween(0, 5),
            'views_count' => $this->faker->numberBetween(0, 20),
            'unique_views_count' => $this->faker->numberBetween(0, 10),
        ]);
    }

    /**
     * Indicate that the forum thread is controversial (high views but mixed likes).
     */
    public function controversial(): static
    {
        return $this->state(fn (array $attributes) => [
            'likes_count' => $this->faker->numberBetween(5, 15),
            'views_count' => $this->faker->numberBetween(150, 400),
            'unique_views_count' => $this->faker->numberBetween(80, 150),
        ]);
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (ForumThread $forumThread) {
            // Attach 1-4 random tags to the forum thread
            $tags = Tag::inRandomOrder()->limit($this->faker->numberBetween(1, 4))->get();
            if ($tags->isNotEmpty()) {
                $forumThread->tags()->attach($tags);
            }
        });
    }
}
