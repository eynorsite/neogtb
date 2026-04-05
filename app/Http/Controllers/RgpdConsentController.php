<?php

namespace App\Http\Controllers;

use App\Models\CookieConsent;
use App\Models\GdprRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RgpdConsentController extends Controller
{
    /**
     * Enregistrer ou mettre à jour le consentement cookies.
     */
    public function storeConsent(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'consents' => 'required|array',
            'consents.analytics' => 'required|boolean',
            'consents.marketing' => 'required|boolean',
        ]);

        $visitorId = $request->cookie('neogtb_visitor_id') ?? Str::uuid()->toString();
        $ipHash = hash('sha256', $request->ip());
        $userAgentHash = hash('sha256', $request->userAgent() ?? '');

        $hasAccepted = $validated['consents']['analytics'] || $validated['consents']['marketing'];

        $consent = CookieConsent::updateOrCreate(
            ['visitor_id' => $visitorId],
            [
                'ip_hash' => $ipHash,
                'consents' => $validated['consents'],
                'version' => $this->getCurrentPolicyVersion(),
                'user_agent_hash' => $userAgentHash,
                'accepted_at' => $hasAccepted ? now() : null,
                'refused_at' => !$hasAccepted ? now() : null,
                'withdrawn_at' => null,
            ]
        );

        return response()->json(['status' => 'ok', 'visitor_id' => $visitorId])
            ->cookie('neogtb_visitor_id', $visitorId, 60 * 24 * 395); // 395 jours
    }

    /**
     * Récupérer les préférences actuelles.
     */
    public function getConsent(Request $request): JsonResponse
    {
        $visitorId = $request->cookie('neogtb_visitor_id');

        if (!$visitorId) {
            return response()->json(['consents' => null]);
        }

        $consent = CookieConsent::where('visitor_id', $visitorId)
            ->whereNull('withdrawn_at')
            ->latest()
            ->first();

        return response()->json([
            'consents' => $consent?->consents,
            'accepted_at' => $consent?->accepted_at,
        ]);
    }

    /**
     * Retirer le consentement.
     */
    public function deleteConsent(Request $request): JsonResponse
    {
        $visitorId = $request->cookie('neogtb_visitor_id');

        if ($visitorId) {
            CookieConsent::where('visitor_id', $visitorId)
                ->whereNull('withdrawn_at')
                ->update(['withdrawn_at' => now()]);
        }

        return response()->json(['status' => 'withdrawn'])
            ->withoutCookie('neogtb_consent');
    }

    /**
     * Soumettre une demande RGPD (droit d'accès, effacement, etc.).
     */
    public function submitGdprRequest(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:access,deletion,portability,rectification,opposition',
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'message' => 'nullable|string|max:2000',
        ]);

        GdprRequest::create($validated);

        return response()->json([
            'status' => 'ok',
            'message' => 'Votre demande a été enregistrée. Nous vous répondrons sous 30 jours.',
        ]);
    }

    private function getCurrentPolicyVersion(): string
    {
        return \App\Models\PrivacyPolicyVersion::where('is_current', true)
            ->value('version') ?? '1.0';
    }
}
