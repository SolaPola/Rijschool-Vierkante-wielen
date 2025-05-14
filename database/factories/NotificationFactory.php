
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
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
            'target_audience' => $this->faker->randomElement(['Student', 'Instructor', 'Both']),
            'message' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement([
                'Sick', 
                'Lesson Change', 
                'Lesson Cancellation', 
                'Lesson Pickup Address Change', 
                'Lesson Goal Change'
            ]),
            'date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}