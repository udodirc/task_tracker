<?php

namespace Database\Factories;

use App\Enums\TaskEnum;
use App\Models\Task;
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
    protected $model = Task::class;

    public function definition()
    {
        return [
            // Берём случайных пользователей для assigned и created
            'assigned_user_id' => User::factory(),
            'created_by_user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([TaskEnum::New, TaskEnum::InProgress, TaskEnum::Done]),
        ];
    }
}
