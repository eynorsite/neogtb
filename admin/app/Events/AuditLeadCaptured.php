<?php
namespace App\Events;

use App\Models\AuditLead;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuditLeadCaptured
{
    use Dispatchable, SerializesModels;

    public function __construct(public AuditLead $lead) {}
}
