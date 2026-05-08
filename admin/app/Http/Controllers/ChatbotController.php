<?php

namespace App\Http\Controllers;

use App\Models\ChatbotConversation;
use App\Models\ChatbotFaq;
use App\Models\ChatbotSetting;
use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatbotController extends Controller
{
    public function __construct(private ChatbotService $service)
    {
    }

    public function bootstrap(Request $request): JsonResponse
    {
        $settings = ChatbotSetting::current();

        if (! $settings->enabled) {
            return response()->json(['enabled' => false]);
        }

        $suggestions = $settings->suggested_questions ?: [];
        if (empty($suggestions)) {
            $suggestions = ChatbotFaq::suggestions()->limit(4)->pluck('question')->toArray();
        }

        return response()->json([
            'enabled'              => true,
            'title'                => $settings->widget_title,
            'subtitle'             => $settings->widget_subtitle,
            'color'                => $settings->widget_color,
            'position'             => $settings->widget_position,
            'welcome_message'      => $settings->welcome_message,
            'suggested_questions'  => $suggestions,
            'require_consent'      => (bool) $settings->require_consent,
            'consent_text'         => $settings->consent_text,
            'fallback_url'         => $settings->fallback_url,
        ]);
    }

    public function consent(Request $request): JsonResponse
    {
        $sessionId = $this->ensureSessionId($request);
        $conv = $this->service->getOrCreateConversation($sessionId, $this->context($request));

        $conv->update([
            'consent_given'    => true,
            'consent_given_at' => now(),
        ]);

        return response()->json(['ok' => true, 'session_id' => $sessionId]);
    }

    public function stream(Request $request): StreamedResponse|JsonResponse
    {
        $settings = ChatbotSetting::current();
        if (! $settings->enabled) {
            return response()->json(['error' => 'disabled'], 403);
        }
        if (! $settings->isWithinBudget()) {
            return response()->json(['error' => 'budget_exceeded'], 429);
        }

        $message = trim((string) $request->input('message', ''));
        if (mb_strlen($message) === 0 || mb_strlen($message) > 2000) {
            return response()->json(['error' => 'invalid_message'], 422);
        }

        $sessionId = $this->ensureSessionId($request);
        $conv = $this->service->getOrCreateConversation($sessionId, $this->context($request));

        if ($settings->require_consent && ! $conv->consent_given) {
            return response()->json(['error' => 'consent_required'], 403);
        }

        $ipKey = 'chatbot:ip:' . hash('sha256', $request->ip() . config('app.key'));
        $sessionKey = 'chatbot:session:' . $sessionId;

        if (RateLimiter::tooManyAttempts($ipKey, $settings->rate_limit_per_ip_per_day)) {
            return response()->json(['error' => 'rate_limit_ip'], 429);
        }
        if (RateLimiter::tooManyAttempts($sessionKey, $settings->rate_limit_per_session)) {
            return response()->json(['error' => 'rate_limit_session'], 429);
        }
        if ($conv->messages_count >= $settings->rate_limit_per_session * 2) {
            return response()->json(['error' => 'rate_limit_session'], 429);
        }

        RateLimiter::hit($ipKey, 86400);
        RateLimiter::hit($sessionKey, 3600);

        return response()->stream(function () use ($conv, $message) {
            ignore_user_abort(false);
            @ini_set('output_buffering', 'off');
            @ini_set('zlib.output_compression', 'false');
            while (ob_get_level() > 0) {
                @ob_end_flush();
            }

            foreach ($this->service->streamReply($conv, $message) as $_) {
                // service prints SSE chunks directly
            }
        }, Response::HTTP_OK, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache, no-transform',
            'Connection'        => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    public function captureLead(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'name'  => 'nullable|string|max:120',
            'note'  => 'nullable|string|max:1000',
        ]);

        $sessionId = $this->ensureSessionId($request);
        $conv = $this->service->getOrCreateConversation($sessionId, $this->context($request));

        $settings = ChatbotSetting::current();
        if ($settings->require_consent && ! $conv->consent_given) {
            return response()->json(['error' => 'consent_required'], 403);
        }

        $conv->markAsLead(
            email: $request->input('email'),
            name: $request->input('name'),
            note: $request->input('note'),
        );

        if ($settings->lead_webhook_enabled && $settings->lead_webhook_email) {
            try {
                \Illuminate\Support\Facades\Mail::raw(
                    "Nouveau lead chatbot.\n\n" .
                    "Email : {$conv->lead_email}\n" .
                    "Nom : {$conv->lead_name}\n" .
                    "Note : {$conv->lead_note}\n" .
                    "Conversation : " . url('/admin/chatbot-conversations/' . $conv->id),
                    fn ($m) => $m->to($settings->lead_webhook_email)
                                 ->subject('[NeoGTB Chatbot] Nouveau lead')
                );
            } catch (\Throwable $e) {
                // silencieux
            }
        }

        return response()->json(['ok' => true]);
    }

    private function ensureSessionId(Request $request): string
    {
        $sid = $request->cookie('neogtb_chat_sid');
        if (! $sid || ! preg_match('/^[a-zA-Z0-9]{32,64}$/', $sid)) {
            $sid = bin2hex(random_bytes(16));
            cookie()->queue(cookie('neogtb_chat_sid', $sid, 60 * 24 * 30, '/', null, $request->isSecure(), true, false, 'lax'));
        }
        return $sid;
    }

    private function context(Request $request): array
    {
        return [
            'ip'       => $request->ip(),
            'ua'       => substr((string) $request->userAgent(), 0, 255),
            'referrer' => substr((string) $request->headers->get('referer', ''), 0, 255),
            'landing'  => substr((string) $request->input('landing', $request->path()), 0, 255),
        ];
    }
}
