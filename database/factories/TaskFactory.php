<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();

        $statuses = ['pending', 'complete', 'backlog'];
        $priorities = ['highest', 'high', 'medium', 'low', 'lowest'];

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'name' => $this->faker->sentence(),
            'status' => $this->faker->randomElement($statuses),
            'priority' => $this->faker->randomElement($priorities),
            'description' => $this->faker->paragraphs(rand(2, 5), true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
