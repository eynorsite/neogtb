<?php

namespace App\Services\Newsletter;

use App\Mail\NewsletterConfirmationMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class NewsletterSubscriptionService
{
    public function subscribe(string $email, string $ipHash): NewsletterSubscriber
    {
        $subscriber = NewsletterSubscriber::updateOrCreate(
            ['email' => $email],
            [
                'confirmation_token' => Str::random(64),
                'is_confirmed' => false,
                'ip_hash' => $ipHash,
                'unsubscribed_at' => null,
            ]
        );

        try {
            Mail::to($email)->queue(new NewsletterConfirmationMail($subscriber));
        } catch (\Throwable $e) {
            Log::error('Newsletter mail failed: ' . $e->getMessage());
        }

        return $subscriber;
    }

    public function confirm(string $token): ?NewsletterSubscriber
    {
        $subscriber = NewsletterSubscriber::where('confirmation_token', $token)->first();
        if (!$subscriber || $subscriber->is_confirmed) {
            return $subscriber;
        }

        $subscriber->update([
            'is_confirmed' => true,
            'confirmed_at' => now(),
            'confirmation_token' => null,
        ]);

        return $subscriber;
    }

    public function unsubscribe(string $email): void
    {
        // Email is encrypted in DB → can't WHERE on it directly. Iterate in PHP.
        NewsletterSubscriber::query()
            ->whereNull('unsubscribed_at')
            ->cursor()
            ->each(function (NewsletterSubscriber $sub) use ($email) {
                if ($sub->email === $email) {
                    $sub->update(['unsubscribed_at' => now()]);
                }
            });
    }
}
