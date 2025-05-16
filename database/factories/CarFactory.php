<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $carBrands = ['Toyota', 'Volkswagen', 'Ford', 'Renault', 'Peugeot', 'BMW', 'Mercedes', 'Audi', 'Hyundai', 'Kia'];
        $brand = $this->faker->randomElement($carBrands);
        
        $carTypes = [
            'Toyota' => ['Corolla', 'Yaris', 'Auris', 'Aygo', 'Camry'],
            'Volkswagen' => ['Golf', 'Polo', 'Passat', 'Up', 'Tiguan'],
            'Ford' => ['Fiesta', 'Focus', 'Mondeo', 'Ka', 'Puma'],
            'Renault' => ['Clio', 'Megane', 'Captur', 'Zoe', 'Twingo'],
            'Peugeot' => ['208', '308', '2008', '3008', '5008'],
            'BMW' => ['1 Series', '3 Series', 'X1', 'X3', 'X5'],
            'Mercedes' => ['A Class', 'C Class', 'E Class', 'GLA', 'GLC'],
            'Audi' => ['A1', 'A3', 'A4', 'Q3', 'Q5'],
            'Hyundai' => ['i10', 'i20', 'i30', 'Kona', 'Tucson'],
            'Kia' => ['Picanto', 'Rio', 'Ceed', 'Niro', 'Sportage']
        ];
        
        return [
            'brand' => $brand,
            'type' => $this->faker->randomElement($carTypes[$brand]),
            'license_plate' => strtoupper($this->faker->bothify('??-###-?')),
            'fuel' => $this->faker->randomElement(['electric', 'petrol']),
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}