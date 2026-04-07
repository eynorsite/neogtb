<?php
namespace App\Events;

use App\Models\CeeLead;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CeeLeadCaptured
{
    use Dispatchable, SerializesModels;

    public function __construct(public CeeLead $lead) {}
}
