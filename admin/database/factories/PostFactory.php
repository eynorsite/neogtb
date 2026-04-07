<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'excerpt' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'author_id' => AdminFactory::new(),
            'status' => 'published',
            'published_at' => now(),
        ];
    }
}
