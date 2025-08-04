<?php

namespace Database\Factories;

use App\Models\ForumThread;
use App\Models\ForumThreadView;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ForumThreadView>
 */
class ForumThreadViewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ForumThreadView::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'forum_thread_id' => ForumThread::factory(),
            'user_id' => User::factory(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'viewed_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}