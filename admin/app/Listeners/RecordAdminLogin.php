<?php
namespace App\Listeners;

use App\Models\Admin;
use App\Services\Auth\LoginTracker;
use Illuminate\Auth\Events\Login;

class RecordAdminLogin
{
    public function __construct(private LoginTracker $tracker) {}

    public function handle(Login $event): void
    {
        if ($event->user instanceof Admin) {
            $this->tracker->record($event->user, request());
        }
    }
}
