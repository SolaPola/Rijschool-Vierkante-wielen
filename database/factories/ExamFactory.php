<?php

namespace Database\Factories;

use App\Models\Registration;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+2 months');
        $startTime = $this->faker->dateTimeBetween('9:00', '16:00');
        $startTimeFormatted = $startTime->format('H:i:s');
        
        // Calculate end time (typically 45-60 minutes after start)
        $endTime = clone $startTime;
        $endTime->modify('+' . $this->faker->randomElement([45, 60]) . ' minutes');
        $endTimeFormatted = $endTime->format('H:i:s');
        
        // If the exam date is in the past, it should have a result
        $result = null;
        if ($startDate < now()) {
            $result = $this->faker->randomElement(['Pass', 'Fail']);
        }
        
        $examCenters = [
            'CBR Amsterdam',
            'CBR Rotterdam',
            'CBR Utrecht',
            'CBR Eindhoven',
            'CBR Den Haag',
            'CBR Groningen',
            'CBR Maastricht',
        ];
        
        return [
            'registration_id' => Registration::factory(),
            'instructor_id' => Instructor::factory(),
            'start_date' => $startDate,
            'start_time' => $startTimeFormatted,
            'end_date' => $startDate,
            'end_time' => $endTimeFormatted,
            'location' => $this->faker->randomElement($examCenters),
            'result' => $result,
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
    
    /**
     * Create a passed exam
     */
    public function passed(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => $this->faker->dateTimeBetween('-2 months', '-1 day'),
            'result' => 'Pass',
        ]);
    }
    
    /**
     * Create a failed exam
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => $this->faker->dateTimeBetween('-2 months', '-1 day'),
            'result' => 'Fail',
        ]);
    }
    
    /**
     * Create a scheduled exam (no result yet)
     */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => $this->faker->dateTimeBetween('+1 day', '+2 months'),
            'result' => null,
        ]);
    }
}