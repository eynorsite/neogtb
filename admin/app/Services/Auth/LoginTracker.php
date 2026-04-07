<?php
namespace App\Services\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;

class LoginTracker
{
    public function record(Admin $admin, Request $request): void
    {
        $admin->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ])->saveQuietly();
    }
}
