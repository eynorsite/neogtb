<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\SitePage;

class PagePolicy
{
    public function viewAny(Admin $user): bool { return in_array($user->role, ['superadmin','admin','editeur']); }
    public function view(Admin $user, SitePage $page): bool { return in_array($user->role, ['superadmin','admin','editeur']); }
    public function create(Admin $user): bool { return in_array($user->role, ['superadmin','admin','editeur']); }
    public function update(Admin $user, SitePage $page): bool { return in_array($user->role, ['superadmin','admin','editeur']); }
    public function delete(Admin $user, SitePage $page): bool { return in_array($user->role, ['superadmin','admin']); }
}
