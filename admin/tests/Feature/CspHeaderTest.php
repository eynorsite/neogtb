<?php

namespace Tests\Feature;

use Database\Factories\SitePageFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Non-régression de la CSP du site public (App\Http\Middleware\FrontCspHeader).
 *
 * La politique est le dernier rempart contre le XSS sur un front dont une partie
 * du HTML vient de la base (bricks, code personnalisé admin) : tout relâchement
 * doit être un choix explicite, pas un effet de bord.
 */
class CspHeaderTest extends TestCase
{
    use RefreshDatabase;

    private function makeHomePage(): void
    {
        SitePageFactory::new()->create([
            'slug' => 'accueil',
            'name' => 'Accueil',
            'is_published' => true,
        ]);
    }

    private function homeCsp(): string
    {
        $this->makeHomePage();

        return (string) $this->get('/')->headers->get('Content-Security-Policy');
    }

    #[Test]
    public function script_src_uses_a_nonce_and_never_unsafe_inline_or_eval(): void
    {
        $csp = $this->homeCsp();

        $this->assertMatchesRegularExpression("/script-src [^;]*'nonce-[A-Za-z0-9+\/]+'/", $csp);
        $this->assertStringNotContainsString("'unsafe-eval'", $csp);

        preg_match('/script-src ([^;]*)/', $csp, $m);
        $this->assertStringNotContainsString("'unsafe-inline'", $m[1] ?? '');
    }

    #[Test]
    public function plugins_are_blocked_and_insecure_subresources_upgraded(): void
    {
        $csp = $this->homeCsp();

        // Durcissement réel : 'none' est strictement plus fort que le fallback default-src.
        $this->assertStringContainsString("object-src 'none'", $csp);
        $this->assertStringContainsString('upgrade-insecure-requests', $csp);
    }

    #[Test]
    public function baseline_directives_are_present(): void
    {
        $csp = $this->homeCsp();

        foreach ([
            "default-src 'self'",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
        ] as $directive) {
            $this->assertStringContainsString($directive, $csp);
        }
    }

    #[Test]
    public function no_third_party_host_is_allowed_beyond_plausible_by_default(): void
    {
        $csp = $this->homeCsp();

        // Sans tracker configuré dans l'admin, la seule origine tierce tolérée
        // est Plausible (cf. SiteConfigService::cspTrackerSources).
        preg_match_all('#https://([a-z0-9.-]+)#i', $csp, $m);
        $this->assertSame(['plausible.io'], array_values(array_unique($m[1])));
    }

    #[Test]
    public function the_back_office_keeps_its_own_nginx_policy(): void
    {
        $this->makeHomePage();

        // FrontCspHeader doit rester silencieux sur admin.* : la CSP du back-office
        // est émise par nginx (elle exige 'unsafe-eval' pour l'Alpine de Filament).
        // Deux headers CSP se cumuleraient en intersection et casseraient le panel.
        $response = $this->get('http://admin.neogtb.fr/');

        $this->assertNull($response->headers->get('Content-Security-Policy'));
    }
}
