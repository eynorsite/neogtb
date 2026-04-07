<?php

namespace Tests\Feature\Auth;

use App\Http\Middleware\EnsureAdminIsActive;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InactiveAdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_inactive_admin_is_logged_out_by_middleware(): void
    {
        $admin = Admin::factory()->create(['is_active' => false]);

        Auth::guard('admin')->login($admin);
        $this->assertTrue(Auth::guard('admin')->check());

        $middleware = new EnsureAdminIsActive();
        $request = Request::create('/admin', 'GET');
        $request->setLaravelSession($this->app['session.store']);

        $middleware->handle($request, fn ($r) => response('ok'));

        $this->assertFalse(Auth::guard('admin')->check());
    }

    #[Test]
    public function test_active_admin_passes_through(): void
    {
        $admin = Admin::factory()->create(['is_active' => true]);
        Auth::guard('admin')->login($admin);

        $middleware = new EnsureAdminIsActive();
        $request = Request::create('/admin', 'GET');
        $request->setLaravelSession($this->app['session.store']);

        $response = $middleware->handle($request, fn ($r) => response('ok'));

        $this->assertSame('ok', $response->getContent());
        $this->assertTrue(Auth::guard('admin')->check());
    }
}
