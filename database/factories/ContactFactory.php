
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
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
            'street_name' => $this->faker->streetName(),
            'house_number' => $this->faker->buildingNumber(),
            'addition' => $this->faker->optional(0.3)->randomElement(['A', 'B', 'C', 'I', 'II', 'III', 'a', 'b', 'c']),
            'postcode' => $this->faker->postcode(),
            'place' => $this->faker->city(),
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->optional(0.9)->safeEmail(),
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}