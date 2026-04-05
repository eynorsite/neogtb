<?php

namespace App\Observers;

use App\Models\AdminActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminAuditObserver
{
    public function created(Model $model): void
    {
        $this->log('created', $model, null, $model->toArray());
    }

    public function updated(Model $model): void
    {
        $changes = $model->getChanges();
        $original = collect($model->getOriginal())
            ->only(array_keys($changes))
            ->toArray();

        if (empty($changes)) {
            return;
        }

        $this->log('updated', $model, $original, $changes);
    }

    public function deleted(Model $model): void
    {
        $this->log('deleted', $model, $model->toArray(), null);
    }

    protected function log(string $action, Model $model, ?array $oldValues, ?array $newValues): void
    {
        $admin = Auth::guard('admin')->user();

        if (! $admin) {
            return;
        }

        // Don't log activity logs themselves
        if ($model instanceof AdminActivityLog) {
            return;
        }

        AdminActivityLog::create([
            'admin_id' => $admin->id,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
