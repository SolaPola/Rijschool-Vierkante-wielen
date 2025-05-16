<?php

namespace Database\Factories;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amountExclVat = $this->faker->randomFloat(2, 100, 2000);
        $vat = $amountExclVat * 0.21; // 21% VAT
        $amountInclVat = $amountExclVat + $vat;
        
        return [
            'registration_id' => Registration::factory(),
            'invoice_number' => 'INV-' . $this->faker->unique()->numerify('######'),
            'invoice_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'amount_excl_vat' => $amountExclVat,
            'btw' => $vat,
            'amount_inc_vat' => $amountInclVat,
            'invoice_status' => $this->faker->randomElement(['Unpaid', 'Paid', 'Overdue', 'Canceled']),
            'isactive' => $this->faker->boolean(90),
            'remark' => $this->faker->optional(0.3)->sentence(),
        ];
    }
    
    /**
     * Create a paid invoice
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'invoice_status' => 'Paid',
            'invoice_date' => $this->faker->dateTimeBetween('-6 months', '-14 days'),
        ]);
    }
    
    /**
     * Create an unpaid invoice
     */
    public function unpaid(): static
    {
        return $this->state(fn (array $attributes) => [
            'invoice_status' => 'Unpaid',
            'invoice_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ]);
    }
    
    /**
     * Create an overdue invoice
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'invoice_status' => 'Overdue',
            'invoice_date' => $this->faker->dateTimeBetween('-6 months', '-31 days'),
        ]);
    }
}