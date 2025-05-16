<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $endDate = $this->faker->optional(0.7)->dateTimeBetween($startDate, '+6 months');
        
        return [
            'student_id' => Student::factory(),
            'package_id' => Package::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}