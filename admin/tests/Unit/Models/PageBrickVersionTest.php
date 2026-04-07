<?php

namespace Tests\Unit\Models;

use App\Models\PageBrick;
use Database\Factories\PageBrickFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PageBrickVersionTest extends TestCase
{
    use RefreshDatabase;

    private function makeBrick(array $attrs = []): PageBrick
    {
        return PageBrickFactory::new()->create($attrs);
    }

    #[Test]
    public function new_brick_starts_at_initial_version(): void
    {
        $brick = $this->makeBrick();
        $this->assertSame(PageBrick::INITIAL_VERSION, $brick->version);
        $this->assertSame(1, $brick->version);
    }

    #[Test]
    public function bump_version_increments_and_persists(): void
    {
        $brick = $this->makeBrick();
        $this->assertSame(1, $brick->version);

        $new = $brick->bumpVersion();
        $this->assertSame(2, $new);
        $this->assertSame(2, $brick->fresh()->version);

        $brick->bumpVersion();
        $this->assertSame(3, $brick->fresh()->version);
    }

    #[Test]
    public function with_version_scope_filters_correctly(): void
    {
        $brick = $this->makeBrick();
        $brick->bumpVersion(); // 2
        $brick->bumpVersion(); // 3

        $this->assertTrue(PageBrick::query()->withVersion(3)->where('id', $brick->id)->exists());
        $this->assertFalse(PageBrick::query()->withVersion(1)->where('id', $brick->id)->exists());
    }

    #[Test]
    public function version_is_cast_to_integer(): void
    {
        $brick = $this->makeBrick();
        $this->assertIsInt($brick->version);
    }
}
