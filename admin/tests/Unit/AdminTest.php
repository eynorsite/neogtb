<?php

namespace Tests\Unit;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_identifies_roles_with_hierarchy(): void
    {
        $superadmin = Admin::factory()->create(['role' => 'superadmin']);
        $admin = Admin::factory()->create(['role' => 'admin']);
        $editeur = Admin::factory()->create(['role' => 'editeur']);
        $lecteur = Admin::factory()->create(['role' => 'lecteur']);

        // superadmin a tous les rôles
        $this->assertTrue($superadmin->isSuperAdmin());
        $this->assertTrue($superadmin->isAdmin());
        $this->assertTrue($superadmin->isEditeur());

        // admin n'est pas superadmin mais est admin et editeur
        $this->assertFalse($admin->isSuperAdmin());
        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($admin->isEditeur());

        // editeur n'est ni admin ni superadmin
        $this->assertFalse($editeur->isSuperAdmin());
        $this->assertFalse($editeur->isAdmin());
        $this->assertTrue($editeur->isEditeur());

        // lecteur n'a aucun rôle élevé
        $this->assertFalse($lecteur->isSuperAdmin());
        $this->assertFalse($lecteur->isAdmin());
        $this->assertFalse($lecteur->isEditeur());
    }

    #[Test]
    public function only_admin_and_superadmin_can_delete(): void
    {
        $superadmin = Admin::factory()->create(['role' => 'superadmin']);
        $admin = Admin::factory()->create(['role' => 'admin']);
        $editeur = Admin::factory()->create(['role' => 'editeur']);
        $lecteur = Admin::factory()->create(['role' => 'lecteur']);

        $this->assertTrue($superadmin->canDelete());
        $this->assertTrue($admin->canDelete());
        $this->assertFalse($editeur->canDelete());
        $this->assertFalse($lecteur->canDelete());
    }
}
