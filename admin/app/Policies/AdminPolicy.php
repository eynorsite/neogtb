<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    public function viewAny(Admin $user): bool { return $user->isSuperAdmin(); }
    public function view(Admin $user, Admin $model): bool { return $user->isSuperAdmin() || $user->id === $model->id; }
    public function create(Admin $user): bool { return $user->isSuperAdmin(); }
    public function update(Admin $user, Admin $model): bool { return $user->isSuperAdmin(); }
    public function delete(Admin $user, Admin $model): bool { return $user->isSuperAdmin() && $user->id !== $model->id && !$model->isSuperAdmin(); }
}
