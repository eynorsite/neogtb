<?php

namespace Tests\Unit\Observers;

use App\Models\Admin;
use App\Models\AdminActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminAuditObserverTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_creates_log_on_admin_save(): void
    {
        $actor = Admin::factory()->create();
        $this->actingAs($actor, 'admin');

        $before = AdminActivityLog::count();

        Admin::factory()->create();

        $this->assertGreaterThan($before, AdminActivityLog::count());
    }
}
