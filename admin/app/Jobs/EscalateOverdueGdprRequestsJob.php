<?php

namespace App\Jobs;

use App\Mail\OverdueGdprNotificationMail;
use App\Models\GdprRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EscalateOverdueGdprRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $overdue = GdprRequest::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(25))
            ->get();

        if ($overdue->isEmpty()) return;

        Mail::to('rgpd@neogtb.fr')->queue(new OverdueGdprNotificationMail($overdue));
    }
}
