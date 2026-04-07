<?php
namespace App\Events;

use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirmed
{
    use Dispatchable, SerializesModels;

    public function __construct(public NewsletterSubscriber $subscriber) {}
}
