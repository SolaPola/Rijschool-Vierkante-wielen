<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PickupAddress>
 */
class PickupAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street_name' => $this->faker->streetName(),
            'house_number' => $this->faker->buildingNumber(),
            'addition' => $this->faker->optional(0.3)->randomElement(['A', 'B', 'C', 'I', 'II', 'III', 'a', 'b', 'c']),
            'postcode' => $this->faker->postcode(),
            'place' => $this->faker->city(),
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}