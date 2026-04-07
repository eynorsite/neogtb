<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\GdprRequest;

class GdprRequestPolicy
{
    public function viewAny(Admin $user): bool { return in_array($user->role, ['superadmin','admin']); }
    public function view(Admin $user, GdprRequest $request): bool { return in_array($user->role, ['superadmin','admin']); }
    public function create(Admin $user): bool { return false; }
    public function update(Admin $user, GdprRequest $request): bool { return in_array($user->role, ['superadmin','admin']); }
    public function delete(Admin $user, GdprRequest $request): bool { return $user->isSuperAdmin(); }
}
