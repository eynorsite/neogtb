<?php

namespace Database\Factories;

use App\Models\SitePage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SitePageFactory extends Factory
{
    protected $model = SitePage::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        return [
            'slug' => Str::slug($name) . '-' . Str::random(6),
            'name' => $name,
            'is_published' => true,
            'order' => 0,
        ];
    }
}
