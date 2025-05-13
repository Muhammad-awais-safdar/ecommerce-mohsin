<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->name,
            'customer_phone' => $this->faker->phoneNumber,
            'shipping_address' => $this->faker->address,
            'total_amount' => $this->faker->randomFloat(2, 500, 5000),
            'status' => $this->faker->randomElement(['pending', 'paid']),
            'tracking_status' => $this->faker->randomElement(['Processing', 'Shipped', 'In Transit', 'Delivered']),
            'tracking_number' => strtoupper('TRK' . $this->faker->unique()->numerify('########')),
            'created_at' => $this->faker->dateTimeBetween('-20 days', 'now'),
            'updated_at' => now(),
        ];
    }
}
