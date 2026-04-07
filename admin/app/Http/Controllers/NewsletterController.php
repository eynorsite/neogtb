<?php

namespace App\Http\Controllers;

use App\Services\Newsletter\NewsletterSubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request, NewsletterSubscriptionService $service): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
        ]);

        $service->subscribe($validated['email'], hash('sha256', $request->ip()));

        return response()->json(['status' => 'ok', 'message' => 'Vérifiez votre email pour confirmer.']);
    }

    public function confirm(string $token, NewsletterSubscriptionService $service)
    {
        $subscriber = $service->confirm($token);

        abort_if($subscriber === null, 404);

        return view('front.newsletter-confirmed');
    }

    public function unsubscribe(Request $request, NewsletterSubscriptionService $service): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $service->unsubscribe($validated['email']);

        return response()->json(['status' => 'ok']);
    }
}
