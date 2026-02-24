<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total' => fake()->randomFloat(2, 50, 5000),
            'status' => fake()->randomElement(['pending', 'completed', 'cancelled']),
        ];
    }
}
