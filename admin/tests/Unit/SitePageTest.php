<?php

namespace Tests\Unit;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SitePageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_have_bricks(): void
    {
        $page = SitePage::create([
            'slug' => 'test-page',
            'name' => 'Page test',
            'is_published' => true,
            'order' => 1,
        ]);

        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero',
            'brick_name' => 'Hero test',
            'content' => ['titre' => 'Bienvenue'],
            'settings' => [],
            'order' => 0,
            'is_visible' => true,
        ]);

        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta',
            'brick_name' => 'CTA test',
            'content' => ['titre' => 'Contactez-nous'],
            'settings' => [],
            'order' => 1,
            'is_visible' => true,
        ]);

        $this->assertCount(2, $page->bricks);
        $this->assertEquals('hero', $page->bricks->first()->brick_type);
    }

    #[Test]
    public function visible_bricks_excludes_hidden_ones(): void
    {
        $page = SitePage::create([
            'slug' => 'test-visible',
            'name' => 'Test visible',
            'is_published' => true,
            'order' => 1,
        ]);

        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero',
            'brick_name' => 'Visible',
            'content' => [],
            'settings' => [],
            'order' => 0,
            'is_visible' => true,
        ]);

        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'cta',
            'brick_name' => 'Masqué',
            'content' => [],
            'settings' => [],
            'order' => 1,
            'is_visible' => false,
        ]);

        $this->assertCount(2, $page->bricks);
        $this->assertCount(1, $page->visibleBricks);
        $this->assertEquals('Visible', $page->visibleBricks->first()->brick_name);
    }

    #[Test]
    public function deleting_page_cascades_to_bricks(): void
    {
        $page = SitePage::create([
            'slug' => 'cascade-test',
            'name' => 'Cascade',
            'is_published' => true,
            'order' => 1,
        ]);

        PageBrick::create([
            'page_id' => $page->id,
            'brick_type' => 'hero',
            'brick_name' => 'Test',
            'content' => [],
            'settings' => [],
            'order' => 0,
            'is_visible' => true,
        ]);

        $pageId = $page->id;
        $page->forceDelete();

        $this->assertEquals(0, PageBrick::where('page_id', $pageId)->count());
    }
}
