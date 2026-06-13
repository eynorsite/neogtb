<?php

namespace App\Http\Middleware;

use App\Services\SiteConfigService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

/**
 * CSP du site public, par nonce (retrait de 'unsafe-inline' du script-src).
 *
 * Pose le header Content-Security-Policy sur les réponses HTML du front, avec un
 * nonce par requête (généré via Vite::useCspNonce() — appliqué automatiquement aux
 * balises @vite et récupérable dans les vues via la directive @cspNonce).
 *
 * NE TOUCHE PAS l'admin Filament (admin.neogtb.fr / chemins /admin, /livewire) :
 * il garde sa propre CSP côté nginx, avec 'unsafe-eval' (Alpine embarqué par Filament).
 * Sa CSP est émise par nginx ; ici on l'exclut pour éviter un double header.
 */
class FrontCspHeader
{
    public function __construct(private readonly SiteConfigService $site) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isAdmin($request)) {
            return $next($request);
        }

        // Généré AVANT le rendu : les balises @vite reçoivent le nonce automatiquement.
        $nonce = Vite::useCspNonce();

        $response = $next($request);

        // CSP uniquement sur les documents HTML (pas les réponses JSON/API ni les redirections).
        $contentType = (string) $response->headers->get('Content-Type', '');
        if ($contentType !== '' && ! str_contains($contentType, 'text/html')) {
            return $response;
        }

        $response->headers->set('Content-Security-Policy', $this->policy($nonce));

        return $response;
    }

    /** L'admin Filament conserve sa CSP nginx (host admin.* en prod, chemins /admin|/livewire en local). */
    private function isAdmin(Request $request): bool
    {
        return str_starts_with($request->getHost(), 'admin.')
            || $request->is('admin', 'admin/*', 'livewire/*');
    }

    private function policy(string $nonce): string
    {
        $script = ["'self'", "'nonce-{$nonce}'", 'https://plausible.io'];
        $connect = ["'self'", 'https://plausible.io'];
        $img = ["'self'", 'data:'];
        $frame = [];

        // Domaines des trackers tiers ajoutés UNIQUEMENT si configurés dans l'admin
        // (sinon CSP stricte Plausible-only). Source unique : SiteConfigService.
        $t = $this->site->cspTrackerSources();
        $script = array_merge($script, $t['script']);
        $connect = array_merge($connect, $t['connect']);
        $img = array_merge($img, $t['img']);
        $frame = array_merge($frame, $t['frame']);

        $directives = [
            "default-src 'self'",
            'script-src '.implode(' ', $script),
            "style-src 'self' 'unsafe-inline'",
            "font-src 'self' data:",
            'img-src '.implode(' ', $img),
            'connect-src '.implode(' ', $connect),
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
        ];

        if ($frame !== []) {
            $directives[] = 'frame-src '.implode(' ', $frame);
        }

        return implode('; ', $directives).';';
    }
}
