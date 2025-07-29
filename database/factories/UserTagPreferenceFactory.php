<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Tag;
use App\Models\UserTagPreference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserTagPreference>
 */
class UserTagPreferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserTagPreference::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tag_id' => Tag::factory(),
            'like_score' => $this->faker->randomFloat(2, 0, 50),
            'view_score' => $this->faker->randomFloat(2, 0, 100),
            'total_score' => function (array $attributes) {
                return ($attributes['like_score'] * 2) + $attributes['view_score'];
            },
            'last_interaction_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
