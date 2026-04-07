<?php

namespace Database\Factories;

use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostCategoryFactory extends Factory
{
    protected $model = PostCategory::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'is_active' => true,
        ];
    }
}
