<?php

namespace Database\Factories;

use App\Models\CeeLead;
use Illuminate\Database\Eloquent\Factories\Factory;

class CeeLeadFactory extends Factory
{
    protected $model = CeeLead::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'sector' => 'tertiaire',
            'payload' => [],
        ];
    }
}
