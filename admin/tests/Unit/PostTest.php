<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_calculates_reading_time_on_save(): void
    {
        $admin = Admin::factory()->create();
        $category = PostCategory::create(['name' => 'Test', 'slug' => 'test', 'is_active' => true]);

        $post = Post::create([
            'title' => 'Article test',
            'slug' => 'article-test',
            'content' => str_repeat('mot ', 600),
            'author_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
        ]);

        $this->assertEquals(3, $post->reading_time);
    }

    #[Test]
    public function it_belongs_to_a_category(): void
    {
        $admin = Admin::factory()->create();
        $category = PostCategory::create(['name' => 'GTB', 'slug' => 'gtb', 'is_active' => true]);

        $post = Post::create([
            'title' => 'Test',
            'slug' => 'test',
            'content' => 'Contenu',
            'author_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $this->assertInstanceOf(PostCategory::class, $post->category);
        $this->assertEquals('GTB', $post->category->name);
    }

    #[Test]
    public function it_can_have_tags(): void
    {
        $admin = Admin::factory()->create();
        $category = PostCategory::create(['name' => 'Test', 'slug' => 'test', 'is_active' => true]);

        $post = Post::create([
            'title' => 'Test tags',
            'slug' => 'test-tags',
            'content' => 'Contenu',
            'author_id' => $admin->id,
            'category_id' => $category->id,
            'status' => 'published',
        ]);

        $tag1 = PostTag::create(['name' => 'BACnet', 'slug' => 'bacnet']);
        $tag2 = PostTag::create(['name' => 'Modbus', 'slug' => 'modbus']);

        $post->tags()->attach([$tag1->id, $tag2->id]);

        $this->assertCount(2, $post->fresh()->tags);
        $this->assertTrue($post->tags->contains($tag1));
    }
}
