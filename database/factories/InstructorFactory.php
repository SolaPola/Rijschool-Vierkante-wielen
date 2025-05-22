<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
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
            'number' => 'INS' . $this->faker->unique()->numerify('####'),
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}