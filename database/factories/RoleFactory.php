<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->randomElement(['Admin', 'Student', 'Instructor',]),
            'isactive' => $this->faker->boolean(90), // 90% chance of being active
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }

    /**
     * Create an admin role
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Admin',
        ]);
    }

    /**
     * Create a student role
     */
    public function student(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Student',
        ]);
    }

    /**
     * Create an instructor role
     */
    public function instructor(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Instructor',
        ]);
    }
}