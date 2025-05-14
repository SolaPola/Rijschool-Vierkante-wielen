<?php

namespace Database\Factories;

use App\Models\Registration;
use App\Models\Instructor;
use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DrivingLesson>
 */
class DrivingLessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $startTime = $this->faker->dateTimeBetween('8:00', '18:00');
        $startTimeFormatted = $startTime->format('H:i:s');
        
        // Calculate end time (typically 1-2 hours after start)
        $endTime = clone $startTime;
        $endTime->modify('+' . $this->faker->randomElement([60, 90, 120]) . ' minutes');
        $endTimeFormatted = $endTime->format('H:i:s');
        
        return [
            'registration_id' => Registration::factory(),
            'instructor_id' => Instructor::factory(),
            'car_id' => Car::factory(),
            'start_date' => $startDate,
            'start_time' => $startTimeFormatted,
            'end_date' => $startDate,
            'end_time' => $endTimeFormatted,
            'lesson_status' => $this->faker->randomElement(['Planned', 'Completed', 'Canceled']),
            'goal' => $this->faker->optional(0.8)->sentence(),
            'student_comment' => $this->faker->optional(0.6)->sentence(),
            'commentary_instructor' => $this->faker->optional(0.7)->sentence(),
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
    
    /**
     * Create a planned lesson
     */
    public function planned(): static
    {
        return $this->state(fn (array $attributes) => [
            'lesson_status' => 'Planned',
            'start_date' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'student_comment' => null,
            'commentary_instructor' => null,
        ]);
    }
    
    /**
     * Create a completed lesson
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'lesson_status' => 'Completed',
            'start_date' => $this->faker->dateTimeBetween('-2 weeks', 'now'),
            'student_comment' => $this->faker->sentence(),
            'commentary_instructor' => $this->faker->paragraph(),
        ]);
    }
}