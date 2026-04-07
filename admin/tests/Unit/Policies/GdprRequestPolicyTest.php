<?php

namespace Tests\Unit\Policies;

use App\Models\Admin;
use App\Models\GdprRequest;
use App\Policies\GdprRequestPolicy;
use Database\Factories\GdprRequestFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GdprRequestPolicyTest extends TestCase
{
    use RefreshDatabase;

    private function policy(): GdprRequestPolicy
    {
        return new GdprRequestPolicy();
    }

    #[Test]
    public function admin_can_view_and_update(): void
    {
        $admin = Admin::factory()->create(['role' => 'admin']);
        $req = GdprRequestFactory::new()->create();

        $this->assertTrue($this->policy()->viewAny($admin));
        $this->assertTrue($this->policy()->view($admin, $req));
        $this->assertTrue($this->policy()->update($admin, $req));
    }

    #[Test]
    public function lecteur_cannot_view_or_update(): void
    {
        $lecteur = Admin::factory()->create(['role' => 'lecteur']);
        $req = GdprRequestFactory::new()->create();

        $this->assertFalse($this->policy()->viewAny($lecteur));
        $this->assertFalse($this->policy()->view($lecteur, $req));
        $this->assertFalse($this->policy()->update($lecteur, $req));
    }

    #[Test]
    public function only_superadmin_can_delete(): void
    {
        $superadmin = Admin::factory()->superadmin()->create();
        $admin = Admin::factory()->create(['role' => 'admin']);
        $req = GdprRequestFactory::new()->create();

        $this->assertTrue($this->policy()->delete($superadmin, $req));
        $this->assertFalse($this->policy()->delete($admin, $req));
    }
}
