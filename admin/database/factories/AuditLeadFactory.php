<?php

namespace Database\Factories;

use App\Models\AuditLead;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditLeadFactory extends Factory
{
    protected $model = AuditLead::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->name(),
            'company' => fake()->company(),
            'score' => fake()->numberBetween(50, 100),
            'status' => 'new',
        ];
    }
}
