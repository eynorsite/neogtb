<?php

namespace Database\Factories;

use App\Models\GdprRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class GdprRequestFactory extends Factory
{
    protected $model = GdprRequest::class;

    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['access', 'deletion', 'portability', 'rectification', 'opposition']),
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->name(),
            'message' => fake()->paragraph(),
            'status' => 'pending',
        ];
    }
}
