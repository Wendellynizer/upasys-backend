<?php

namespace Database\Factories;

use App\Models\PaymentFrequency;
use App\Models\RentalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RentalUnit>
 */
class RentalUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_name' => fake()->address(),
                'unit_owner_id' => User::inRandomOrder()->first()->id,
            'description' => fake()->paragraphs(3, $asText=true),
            'base_rent_amount' => fake()->randomFloat(2, 500, 2000),
                'payment_frequency_id' => PaymentFrequency::inRandomOrder()->first()->id,
            'is_available' => true,
        ];
    }
}
