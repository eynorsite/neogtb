<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Post;

class PostPolicy
{
    public function viewAny(Admin $user): bool { return in_array($user->role, ['superadmin','admin','editeur']); }
    public function view(Admin $user, Post $post): bool { return in_array($user->role, ['superadmin','admin','editeur']); }
    public function create(Admin $user): bool { return in_array($user->role, ['superadmin','admin','editeur']); }
    public function update(Admin $user, Post $post): bool { return in_array($user->role, ['superadmin','admin','editeur']); }
    public function delete(Admin $user, Post $post): bool { return in_array($user->role, ['superadmin','admin']); }
}
