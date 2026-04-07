<?php

namespace Tests\Unit\Policies;

use App\Models\Admin;
use App\Models\Post;
use App\Policies\PostPolicy;
use Database\Factories\PostFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;

    private function policy(): PostPolicy
    {
        return new PostPolicy();
    }

    #[Test]
    public function editeur_can_create_and_update(): void
    {
        $editeur = Admin::factory()->editeur()->create();
        $post = PostFactory::new()->create(['author_id' => $editeur->id]);

        $this->assertTrue($this->policy()->create($editeur));
        $this->assertTrue($this->policy()->update($editeur, $post));
    }

    #[Test]
    public function lecteur_cannot_create_or_update(): void
    {
        $lecteur = Admin::factory()->create(['role' => 'lecteur']);
        $post = PostFactory::new()->create();

        $this->assertFalse($this->policy()->create($lecteur));
        $this->assertFalse($this->policy()->update($lecteur, $post));
    }

    #[Test]
    public function admin_can_delete(): void
    {
        $admin = Admin::factory()->create(['role' => 'admin']);
        $post = PostFactory::new()->create();

        $this->assertTrue($this->policy()->delete($admin, $post));
    }

    #[Test]
    public function editeur_cannot_delete(): void
    {
        $editeur = Admin::factory()->editeur()->create();
        $post = PostFactory::new()->create();

        $this->assertFalse($this->policy()->delete($editeur, $post));
    }
}
