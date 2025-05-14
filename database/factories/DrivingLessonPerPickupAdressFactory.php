<?php

namespace Database\Factories;

use App\Models\Driving_lesson;
use App\Models\Driving_lesson_per_pickup_adress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DrivingLessonPickupAddress>
 */
class DrivingLessonPickupAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'driving_lesson_id' => Driving_lesson::factory(),
            'pickup_address_id' => Driving_lesson_per_pickup_adress::factory(),
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
