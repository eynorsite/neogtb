<?php

namespace App\Services;

use App\Models\PageContent;

class PageContentService
{
    /**
     * Récupère une valeur unique.
     */
    public function get(string $page, string $section, string $key, mixed $default = null): mixed
    {
        return PageContent::getValue($page, $section, $key, $default);
    }

    /**
     * Récupère toutes les paires key/value d'une section.
     */
    public function section(string $page, string $section): array
    {
        $data = PageContent::getPageData($page);
        return $data[$section] ?? [];
    }

    /**
     * Reconstruit un tableau indexé à partir de clés plates.
     * Ex: stat_1_valeur, stat_1_label, stat_2_valeur... → [{valeur: ..., label: ...}, ...]
     * Utilise la clé {prefix}_count pour savoir combien d'items.
     */
    public function items(string $page, string $section, string $prefix, array $fields): array
    {
        $sectionData = $this->section($page, $section);
        $count = (int) ($sectionData["{$prefix}_count"] ?? 0);

        $items = [];
        for ($i = 1; $i <= $count; $i++) {
            $item = [];
            foreach ($fields as $field) {
                $item[$field] = $sectionData["{$prefix}_{$i}_{$field}"] ?? '';
            }
            $items[] = $item;
        }

        return $items;
    }

    /**
     * Reconstruit un tableau simple indexé (valeurs seules).
     * Ex: identite_1, identite_2... → ['valeur1', 'valeur2']
     */
    public function simpleItems(string $page, string $section, string $prefix): array
    {
        $sectionData = $this->section($page, $section);
        $count = (int) ($sectionData["{$prefix}_count"] ?? 0);

        $items = [];
        for ($i = 1; $i <= $count; $i++) {
            $val = $sectionData["{$prefix}_{$i}"] ?? '';
            if ($val !== '') {
                $items[] = $val;
            }
        }

        return $items;
    }

    /**
     * Récupère l'ordre des sections pour une page.
     */
    public function sectionsOrder(string $page): array
    {
        $order = PageContent::getValue($page, '_meta', 'sections_order', '');
        return $order ? explode(',', $order) : [];
    }

    /**
     * Invalide le cache d'une page.
     */
    public function invalidate(?string $page = null): void
    {
        PageContent::clearCache($page);
    }
}
