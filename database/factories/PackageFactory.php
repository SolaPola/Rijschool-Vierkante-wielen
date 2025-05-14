<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['Package1', 'Package2', 'Package3']),
            'number_of_lessons' => $this->faker->randomElement([10, 20, 30, 40]),
            'price_per_lesson' => $this->faker->randomFloat(2, 40, 60),
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
    
    /**
     * Create a basic package (Package1)
     */
    public function basic(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'Package1',
            'number_of_lessons' => 10,
            'price_per_lesson' => 45.00,
        ]);
    }
    
    /**
     * Create a standard package (Package2)
     */
    public function standard(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'Package2',
            'number_of_lessons' => 20,
            'price_per_lesson' => 42.50,
        ]);
    }
    
    /**
     * Create a premium package (Package3)
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'Package3',
            'number_of_lessons' => 30,
            'price_per_lesson' => 40.00,
        ]);
    }
}