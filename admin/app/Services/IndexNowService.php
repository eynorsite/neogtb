<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Soumet des URLs à IndexNow (Bing, Yandex, Seznam, Naver…) pour une indexation
 * quasi immédiate — levier GEO pour Microsoft Copilot (qui cite l'index Bing).
 *
 * Preuve de propriété : un fichier public/<key>.txt contenant la clé (voir config/indexnow.php).
 */
class IndexNowService
{
    /**
     * IndexNow est-il actif ? (par défaut : production uniquement)
     */
    public function isEnabled(): bool
    {
        $flag = config('indexnow.enabled');

        if ($flag !== null) {
            return filter_var($flag, FILTER_VALIDATE_BOOLEAN);
        }

        return app()->isProduction();
    }

    public function key(): string
    {
        return (string) config('indexnow.key', '');
    }

    /**
     * Host du site (dérivé de app.url), ex. « neogtb.fr ».
     */
    public function host(): string
    {
        return parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'neogtb.fr';
    }

    /**
     * Soumet une liste d'URLs absolues (toutes sur le même host).
     *
     * @return int|null  Code HTTP renvoyé par IndexNow, ou null si désactivé / rien à envoyer / échec réseau.
     */
    public function submit(array $urls): ?int
    {
        $host = $this->host();

        // Ne garde que des URLs absolues du bon host, dédupliquées.
        $urls = collect($urls)
            ->filter(fn ($u) => is_string($u) && $u !== '')
            ->filter(fn ($u) => parse_url($u, PHP_URL_HOST) === $host)
            ->unique()
            ->values()
            ->all();

        if (empty($urls) || ! $this->isEnabled() || $this->key() === '') {
            return null;
        }

        $payload = [
            'host' => $host,
            'key' => $this->key(),
            'keyLocation' => "https://{$host}/{$this->key()}.txt",
            'urlList' => array_slice($urls, 0, 10000), // plafond IndexNow par requête
        ];

        try {
            $response = Http::timeout(15)
                ->acceptJson()
                ->post((string) config('indexnow.endpoint'), $payload);

            Log::info('IndexNow: soumission', [
                'count' => count($payload['urlList']),
                'status' => $response->status(),
            ]);

            return $response->status();
        } catch (\Throwable $e) {
            // Fail-safe : une indisponibilité d'IndexNow ne doit jamais casser une requête / un cron.
            Log::warning('IndexNow: échec soumission — ' . $e->getMessage());

            return null;
        }
    }
}
