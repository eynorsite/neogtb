<?php

namespace Database\Factories;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsletterSubscriberFactory extends Factory
{
    protected $model = NewsletterSubscriber::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'is_confirmed' => false,
            'confirmation_token' => Str::random(64),
        ];
    }
}
