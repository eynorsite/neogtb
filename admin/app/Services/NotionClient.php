<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Client minimal de l'API publique Notion, pour la machine à articles de blog
 * (cf. App\Console\Commands\NotionSyncArticles). Même client que sur eynor.fr :
 * les deux sites lisent la même base Notion, chacun filtre sa plateforme.
 *
 * Authentification : jeton d'une intégration interne Notion (Bearer). La base
 * « Calendrier de contenu » doit être partagée avec cette intégration
 * (menu ••• de la page → Connexions → ajouter l'intégration).
 *
 * Configuration (.env) :
 *   NOTION_TOKEN=ntn_...
 *   NOTION_BLOG_DATA_SOURCE_ID=980815be-4850-826f-b698-87a29c09681a
 *
 * Version d'API 2025-09-03 : les requêtes passent par les « data sources »
 * (POST /v1/data_sources/{id}/query), plus par /v1/databases/{id}/query.
 */
class NotionClient
{
    public const BASE_URL = 'https://api.notion.com/v1';

    public const VERSION = '2025-09-03';

    public function __construct(
        private readonly ?string $token = null,
    ) {}

    public function isConfigured(): bool
    {
        return ! empty($this->token());
    }

    /**
     * Toutes les pages d'une data source qui passent le filtre (pagination suivie).
     *
     * @param  array<string, mixed>  $filter  filtre au format de l'API Notion
     * @return array<int, array<string, mixed>>|null null si l'API a répondu en erreur
     */
    public function queryDataSource(string $dataSourceId, array $filter = []): ?array
    {
        $pages = [];
        $cursor = null;

        do {
            $body = ['page_size' => 100];
            if ($filter !== []) {
                $body['filter'] = $filter;
            }
            if ($cursor) {
                $body['start_cursor'] = $cursor;
            }

            $json = $this->send('post', "/data_sources/{$dataSourceId}/query", $body)?->json();
            if (! is_array($json)) {
                return null;
            }

            array_push($pages, ...($json['results'] ?? []));
            $cursor = ($json['has_more'] ?? false) ? ($json['next_cursor'] ?? null) : null;
        } while ($cursor);

        return $pages;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getPage(string $pageId): ?array
    {
        return $this->send('get', "/pages/{$pageId}")?->json();
    }

    /**
     * Enfants directs d'un bloc (ou d'une page), pagination suivie.
     *
     * @return array<int, array<string, mixed>>|null
     */
    public function blockChildren(string $blockId): ?array
    {
        $blocks = [];
        $cursor = null;

        do {
            $query = ['page_size' => 100];
            if ($cursor) {
                $query['start_cursor'] = $cursor;
            }

            $json = $this->send('get', "/blocks/{$blockId}/children", $query)?->json();
            if (! is_array($json)) {
                return null;
            }

            array_push($blocks, ...($json['results'] ?? []));
            $cursor = ($json['has_more'] ?? false) ? ($json['next_cursor'] ?? null) : null;
        } while ($cursor);

        return $blocks;
    }

    /**
     * Met à jour des propriétés d'une page (format brut de l'API Notion).
     *
     * @param  array<string, mixed>  $properties
     */
    public function updatePageProperties(string $pageId, array $properties): bool
    {
        return $this->send('patch', "/pages/{$pageId}", ['properties' => $properties])?->successful() ?? false;
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function send(string $method, string $path, array $payload = []): ?Response
    {
        try {
            $response = Http::withToken((string) $this->token())
                ->withHeaders(['Notion-Version' => self::VERSION])
                ->acceptJson()
                ->timeout(30)
                ->retry(2, 1000, throw: false)
                ->{$method}(self::BASE_URL.$path, $payload);
        } catch (\Throwable $e) {
            Log::warning('Notion API injoignable', ['path' => $path, 'error' => $e->getMessage()]);

            return null;
        }

        if (! $response->successful()) {
            Log::warning('Notion API en erreur', [
                'path' => $path,
                'status' => $response->status(),
                'code' => $response->json('code'),
                'message' => $response->json('message'),
            ]);

            return null;
        }

        return $response;
    }

    private function token(): ?string
    {
        return $this->token ?? config('services.notion.token');
    }
}
