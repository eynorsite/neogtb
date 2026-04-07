<?php

namespace Tests\Unit\Policies;

use App\Models\Admin;
use App\Policies\AdminPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminPolicyTest extends TestCase
{
    use RefreshDatabase;

    private AdminPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new AdminPolicy();
    }

    #[Test]
    public function superadmin_can_create_admins(): void
    {
        $superadmin = Admin::factory()->create(['role' => 'superadmin']);
        $this->assertTrue($this->policy->create($superadmin));
    }

    #[Test]
    public function admin_cannot_create_admins(): void
    {
        $admin = Admin::factory()->create(['role' => 'admin']);
        $this->assertFalse($this->policy->create($admin));
    }

    #[Test]
    public function superadmin_cannot_delete_self(): void
    {
        $superadmin = Admin::factory()->create(['role' => 'superadmin']);
        $this->assertFalse($this->policy->delete($superadmin, $superadmin));
    }

    #[Test]
    public function superadmin_cannot_delete_other_superadmin(): void
    {
        $a = Admin::factory()->create(['role' => 'superadmin']);
        $b = Admin::factory()->create(['role' => 'superadmin']);
        $this->assertFalse($this->policy->delete($a, $b));
    }
}
