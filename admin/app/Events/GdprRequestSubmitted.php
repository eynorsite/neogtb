<?php
namespace App\Events;

use App\Models\GdprRequest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GdprRequestSubmitted
{
    use Dispatchable, SerializesModels;

    public function __construct(public GdprRequest $request) {}
}
