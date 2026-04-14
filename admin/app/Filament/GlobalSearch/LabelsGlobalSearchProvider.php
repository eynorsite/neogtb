<?php

namespace App\Filament\GlobalSearch;

use App\Filament\Pages\SiteSettingsPage;
use Filament\GlobalSearch\GlobalSearchResult;
use Filament\GlobalSearch\GlobalSearchResults;
use Filament\GlobalSearch\Providers\Contracts\GlobalSearchProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LabelsGlobalSearchProvider implements GlobalSearchProvider
{
    public function getResults(string $query): ?GlobalSearchResults
    {
        $query = trim($query);

        if (mb_strlen($query) < 2) {
            return GlobalSearchResults::make();
        }

        $index = $this->getIndex();
        $needle = $this->normalize($query);

        $matches = [];

        foreach ($index as $entry) {
            $haystack = $this->normalize(
                $entry['label'] . ' ' . $entry['section'] . ' ' . $entry['tab'] . ' ' . $entry['key']
            );

            if (str_contains($haystack, $needle)) {
                $matches[] = $entry;
            }

            if (count($matches) >= 50) {
                break;
            }
        }

        $builder = GlobalSearchResults::make();

        if (empty($matches)) {
            return $builder;
        }

        $grouped = Collection::make($matches)->groupBy('tab');

        foreach ($grouped as $tabName => $entries) {
            $results = Collection::make($entries)->map(function (array $entry) {
                $url = SiteSettingsPage::getUrl([
                    'tab' => $entry['tab_id'],
                    'field' => $entry['key'],
                ]);

                return new GlobalSearchResult(
                    title: $entry['label'] ?: $entry['key'],
                    url: $url,
                    details: [
                        'Section' => $entry['section'],
                        'Clé' => $entry['key'],
                    ],
                );
            })->all();

            $builder->category($tabName, $results);
        }

        return $builder;
    }

    /**
     * @return array<int, array{key: string, label: string, section: string, tab: string}>
     */
    protected function getIndex(): array
    {
        $path = (new \ReflectionClass(SiteSettingsPage::class))->getFileName();
        $mtime = filemtime($path);
        $cacheKey = 'neogtb.ui_labels_index.' . $mtime;

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($path) {
            return $this->parseIndex(file_get_contents($path));
        });
    }

    /**
     * Parse SiteSettingsPage source to extract ui_labels fields, their section, and tab.
     *
     * Rules:
     *  - A "tab" starts with `Tab::make('Name')` inside a `protected function xxxTab(): Tab`.
     *  - A "section" starts with `Section::make('Name')`.
     *  - A field is a `TextInput|Textarea|RichEditor::make('ui_labels.X')->label('Y')` (label optional).
     *
     * @return array<int, array{key: string, label: string, section: string, tab: string}>
     */
    protected function parseIndex(string $source): array
    {
        $entries = [];
        $lines = preg_split("/\r?\n/", $source);
        $currentTab = '';
        $currentTabId = '';
        $currentSection = '';
        $pendingTabLabel = null;

        foreach ($lines as $i => $line) {
            if (preg_match("/Tab::make\\(\\s*'((?:[^'\\\\]|\\\\.)*)'\\s*\\)/", $line, $m)) {
                $pendingTabLabel = $this->unescape($m[1]);
                $currentTab = $pendingTabLabel;
                $currentTabId = \Illuminate\Support\Str::slug(\Illuminate\Support\Str::transliterate($pendingTabLabel, strict: true));
                $currentSection = '';
            }

            if ($pendingTabLabel !== null && preg_match("/->id\\(\\s*'([a-z0-9\\-]+)'\\s*\\)/", $line, $m)) {
                $currentTabId = $m[1];
            }

            if (preg_match("/Section::make\\(\\s*'((?:[^'\\\\]|\\\\.)*)'\\s*\\)/", $line, $m)) {
                $currentSection = $this->unescape($m[1]);
                continue;
            }

            if (! preg_match("/(?:TextInput|Textarea|RichEditor|Toggle|Select|ColorPicker|FileUpload|KeyValue)::make\\(\\s*'(ui_labels\\.[a-zA-Z0-9_.]+)'\\s*\\)/", $line, $m)) {
                continue;
            }

            $key = $m[1];
            $label = '';

            if (preg_match("/->label\\(\\s*'((?:[^'\\\\]|\\\\.)*)'\\s*\\)/", $line, $lm)) {
                $label = $this->unescape($lm[1]);
            }

            $entries[] = [
                'key' => $key,
                'label' => $label,
                'section' => $currentSection,
                'tab' => $currentTab ?: 'Textes du site',
                'tab_id' => $currentTabId ?: 'textes-du-site',
            ];
        }

        return $entries;
    }

    protected function unescape(string $value): string
    {
        return str_replace(["\\'", '\\\\'], ["'", '\\'], $value);
    }

    protected function normalize(string $value): string
    {
        $value = mb_strtolower($value);
        $value = \Illuminate\Support\Str::ascii($value);

        return preg_replace('/[^a-z0-9]+/', ' ', $value);
    }
}
