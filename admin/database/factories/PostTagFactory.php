<?php

namespace Database\Factories;

use App\Models\PostTag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostTagFactory extends Factory
{
    protected $model = PostTag::class;

    public function definition(): array
    {
        $name = fake()->unique()->word();
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(5),
        ];
    }
}
