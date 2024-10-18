<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), // assuming you have a User model and factory
            'specialization' => $this->faker->word(), // Generates a random word for specialization
            'contact_number' => $this->faker->phoneNumber(), // Generates a random phone number
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
