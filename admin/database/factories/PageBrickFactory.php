<?php

namespace Database\Factories;

use App\Models\PageBrick;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageBrickFactory extends Factory
{
    protected $model = PageBrick::class;

    public function definition(): array
    {
        return [
            'page_id' => SitePageFactory::new(),
            'brick_type' => 'hero',
            'brick_name' => 'hero-default',
            'content' => [],
            'settings' => [],
            'order' => 0,
            'is_visible' => true,
        ];
    }
}
