<?php

namespace Database\Seeders;

use App\Models\PageContent;
use App\Models\SitePage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageContentSeeder extends Seeder
{
    /**
     * Mapping des clés de tableaux vers leur préfixe singulier.
     */
    private const ARRAY_PREFIX_MAP = [
        'stats'            => 'stat',
        'cartes'           => 'carte',
        'questions'        => 'question',
        'etapes'           => 'etape',
        'avis'             => 'avis',
        'points'           => 'point',
        'legende'          => 'legende',
        'compteurs'        => 'compteur',
        'cas'              => 'cas',
        'lignes_gauche'    => 'ligne_gauche',
        'lignes_droite'    => 'ligne_droite',
        'identite'         => 'identite',
        'modele_economique' => 'modele_eco',
        'logos'            => 'logo',
        'tags'             => 'tag',
        'colonnes'         => 'colonne',
        'lignes'           => 'ligne',
        'metriques'        => 'metrique',
    ];

    /**
     * Compteur d'entrées insérées par page.
     */
    private array $stats = [];

    public function run(): void
    {
        $this->command->info('=== PageContentSeeder — Migration briques → page_contents ===');
        $this->command->newLine();

        $pages = SitePage::with(['bricks' => fn ($q) => $q->orderBy('order')])->get();

        if ($pages->isEmpty()) {
            $this->command->warn('Aucune page trouvée dans site_pages.');
            return;
        }

        foreach ($pages as $page) {
            $slug = $page->slug;
            $this->stats[$slug] = 0;
            $sectionSlugs = [];
            $typeCounts = [];

            // Premier passage : compter les types pour savoir lesquels sont dupliqués
            foreach ($page->bricks as $brick) {
                $type = $brick->brick_type;
                $typeCounts[$type] = ($typeCounts[$type] ?? 0) + 1;
            }

            foreach ($page->bricks as $brick) {
                $type = $brick->brick_type;
                $name = $brick->brick_name;
                $content = $brick->content ?? [];
                $settings = $brick->settings ?? [];
                $isVisible = $brick->is_visible;
                $order = $brick->order;

                // Déterminer le nom de section
                $section = $this->buildSectionSlug($type, $name, $typeCounts[$type]);

                // Éviter les doublons de section dans la même page
                $baseSection = $section;
                $suffix = 2;
                while (in_array($section, $sectionSlugs)) {
                    $section = $baseSection . '--' . $suffix;
                    $suffix++;
                }
                $sectionSlugs[] = $section;

                // Meta de la brique
                $this->upsert($slug, $section, '_brick_type', $type, 'text', 'Type de brique');
                $this->upsert($slug, $section, '_brick_name', $name, 'text', 'Nom de la brique');
                $this->upsert($slug, $section, '_visible', $isVisible ? '1' : '0', 'boolean', 'Visible');
                $this->upsert($slug, $section, '_order', (string) $order, 'text', 'Ordre');

                // Aplatir le content
                $this->flattenContent($slug, $section, $content);

                // Aplatir les settings
                $this->flattenSettings($slug, $section, $settings);
            }

            // Créer l'entrée _meta / sections_order
            $sectionsOrder = implode(',', $sectionSlugs);
            $this->upsert($slug, '_meta', 'sections_order', $sectionsOrder, 'text', 'Ordre des sections');

            $this->command->info("  [{$slug}] {$this->stats[$slug]} entrées — " . count($sectionSlugs) . ' sections');
        }

        // Stats finales
        $this->command->newLine();
        $total = array_sum($this->stats);
        $this->command->info("=== Terminé : {$total} entrées au total sur " . count($this->stats) . ' pages ===');
        $this->command->newLine();

        foreach ($this->stats as $pageSlug => $count) {
            $this->command->line("  • {$pageSlug}: {$count} entrées");
        }
    }

    /**
     * Construit le slug de section à partir du type et du nom de brique.
     */
    private function buildSectionSlug(string $type, string $name, int $typeCount): string
    {
        if ($typeCount <= 1) {
            return $type;
        }

        // Le type apparaît plusieurs fois → suffixe avec le slug du nom
        $nameSlug = Str::slug($name);
        return $type . '--' . $nameSlug;
    }

    /**
     * Aplatit le contenu d'une brique en entrées page_contents.
     */
    private function flattenContent(string $page, string $section, array $content): void
    {
        foreach ($content as $key => $value) {
            if ($value === null) {
                continue;
            }

            // Tableau indexé → utiliser le mapping de préfixe
            if (is_array($value) && $this->isIndexedArray($value)) {
                $this->flattenIndexedArray($page, $section, $key, $value);
                continue;
            }

            // Objet associatif (ex: gauge, preview_data) → aplatir en sous-clés
            if (is_array($value)) {
                $this->flattenAssociativeArray($page, $section, $key, $value);
                continue;
            }

            // Scalaire
            $type = $this->detectType($key, $value);
            $label = $this->generateLabel($key);
            $this->upsert($page, $section, $key, (string) $value, $type, $label);
        }
    }

    /**
     * Aplatit un tableau indexé (stats, cartes, etc.) avec compteur et préfixes.
     */
    private function flattenIndexedArray(string $page, string $section, string $arrayKey, array $items): void
    {
        $prefix = self::ARRAY_PREFIX_MAP[$arrayKey] ?? Str::singular($arrayKey);
        $count = count($items);

        // Compteur
        $this->upsert(
            $page,
            $section,
            $prefix . '_count',
            (string) $count,
            'text',
            $this->generateLabel($prefix . '_count')
        );

        foreach ($items as $index => $item) {
            $n = $index + 1; // 1-indexed

            if (is_array($item)) {
                // Chaque élément est un objet avec des champs
                foreach ($item as $field => $fieldValue) {
                    if ($fieldValue === null) {
                        continue;
                    }

                    // Sous-tableaux dans un item (ex: cas.metriques, cas.gauge, cartes.tags, cartes.liste, cartes.preview_data)
                    if (is_array($fieldValue) && $this->isIndexedArray($fieldValue)) {
                        $this->flattenNestedIndexedArray($page, $section, $prefix, $n, $field, $fieldValue);
                        continue;
                    }

                    if (is_array($fieldValue)) {
                        // Objet imbriqué (ex: cas.gauge)
                        foreach ($fieldValue as $subKey => $subVal) {
                            if ($subVal === null) {
                                continue;
                            }
                            $fullKey = "{$prefix}_{$n}_{$field}_{$subKey}";
                            $type = $this->detectType($subKey, (string) $subVal);
                            $label = $this->generateLabel($fullKey);
                            $this->upsert($page, $section, $fullKey, (string) $subVal, $type, $label);
                        }
                        continue;
                    }

                    $fullKey = "{$prefix}_{$n}_{$field}";
                    $strValue = is_bool($fieldValue) ? ($fieldValue ? '1' : '0') : (string) $fieldValue;
                    $type = is_bool($fieldValue) ? 'boolean' : $this->detectType($field, $strValue);
                    $label = $this->generateLabel($fullKey);
                    $this->upsert($page, $section, $fullKey, $strValue, $type, $label);
                }
            } else {
                // Valeur simple (ex: identite, tags)
                $fullKey = "{$prefix}_{$n}";
                $type = $this->detectType($prefix, (string) $item);
                $label = $this->generateLabel($fullKey);
                $this->upsert($page, $section, $fullKey, (string) $item, $type, $label);
            }
        }
    }

    /**
     * Aplatit un sous-tableau indexé imbriqué dans un item.
     * Ex: cas_1_metrique_1_valeur, carte_2_tag_1
     */
    private function flattenNestedIndexedArray(string $page, string $section, string $parentPrefix, int $parentN, string $field, array $items): void
    {
        $subPrefix = self::ARRAY_PREFIX_MAP[$field] ?? Str::singular($field);
        $count = count($items);

        // Compteur du sous-tableau
        $countKey = "{$parentPrefix}_{$parentN}_{$subPrefix}_count";
        $this->upsert($page, $section, $countKey, (string) $count, 'text', $this->generateLabel($countKey));

        foreach ($items as $index => $item) {
            $n = $index + 1;

            if (is_array($item)) {
                foreach ($item as $subField => $subValue) {
                    if ($subValue === null) {
                        continue;
                    }
                    if (is_array($subValue)) {
                        // Cas très imbriqué — sérialiser en JSON
                        $fullKey = "{$parentPrefix}_{$parentN}_{$subPrefix}_{$n}_{$subField}";
                        $this->upsert($page, $section, $fullKey, json_encode($subValue, JSON_UNESCAPED_UNICODE), 'textarea', $this->generateLabel($fullKey));
                        continue;
                    }
                    $fullKey = "{$parentPrefix}_{$parentN}_{$subPrefix}_{$n}_{$subField}";
                    $strValue = is_bool($subValue) ? ($subValue ? '1' : '0') : (string) $subValue;
                    $type = is_bool($subValue) ? 'boolean' : $this->detectType($subField, $strValue);
                    $label = $this->generateLabel($fullKey);
                    $this->upsert($page, $section, $fullKey, $strValue, $type, $label);
                }
            } else {
                // Valeur simple (ex: tags, liste)
                $fullKey = "{$parentPrefix}_{$parentN}_{$subPrefix}_{$n}";
                $type = $this->detectType($subPrefix, (string) $item);
                $label = $this->generateLabel($fullKey);
                $this->upsert($page, $section, $fullKey, (string) $item, $type, $label);
            }
        }
    }

    /**
     * Aplatit un objet associatif (non indexé) en sous-clés.
     * Ex: preview_data → preview_data_valeur, preview_data_contexte
     */
    private function flattenAssociativeArray(string $page, string $section, string $parentKey, array $data): void
    {
        foreach ($data as $subKey => $subValue) {
            if ($subValue === null) {
                continue;
            }

            $fullKey = "{$parentKey}_{$subKey}";

            if (is_array($subValue)) {
                // Récursion pour les sous-objets
                if ($this->isIndexedArray($subValue)) {
                    $this->flattenIndexedArray($page, $section, $fullKey, $subValue);
                } else {
                    $this->flattenAssociativeArray($page, $section, $fullKey, $subValue);
                }
                continue;
            }

            $strValue = is_bool($subValue) ? ($subValue ? '1' : '0') : (string) $subValue;
            $type = is_bool($subValue) ? 'boolean' : $this->detectType($subKey, $strValue);
            $label = $this->generateLabel($fullKey);
            $this->upsert($page, $section, $fullKey, $strValue, $type, $label);
        }
    }

    /**
     * Aplatit les settings d'une brique.
     */
    private function flattenSettings(string $page, string $section, array|object $settings): void
    {
        // Les settings peuvent être un tableau vide [] (cast en array vide)
        if (empty($settings)) {
            return;
        }

        foreach ((array) $settings as $key => $value) {
            if ($value === null) {
                continue;
            }

            $fullKey = "setting_{$key}";

            if (is_array($value)) {
                // Setting complexe → sérialiser en JSON
                $this->upsert($page, $section, $fullKey, json_encode($value, JSON_UNESCAPED_UNICODE), 'textarea', $this->generateLabel($fullKey));
                continue;
            }

            $strValue = is_bool($value) ? ($value ? '1' : '0') : (string) $value;
            $type = is_bool($value) ? 'boolean' : $this->detectType($key, $strValue);
            $label = $this->generateLabel($fullKey);
            $this->upsert($page, $section, $fullKey, $strValue, $type, $label);
        }
    }

    /**
     * Détecte le type d'un champ à partir de sa clé et de sa valeur.
     */
    private function detectType(string $key, string $value): string
    {
        // Booléen
        if (in_array($value, ['0', '1', 'true', 'false'], true)) {
            // Ne détecter comme boolean que si la clé suggère un booléen
            if (in_array($key, ['active', 'visible', 'highlight', 'placeholder', 'is_visible', 'is_published'])) {
                return 'boolean';
            }
        }

        // Image
        if (preg_match('/image|photo|image_fond|logo|avatar|icone_image/', $key)) {
            return 'image';
        }

        // Couleur
        if (preg_match('/couleur|color/', $key)) {
            return 'color';
        }

        // Textarea si texte long
        if (mb_strlen($value) > 200) {
            return 'textarea';
        }

        return 'text';
    }

    /**
     * Génère un label lisible à partir d'une clé.
     *
     * Exemples :
     *   titre           → "Titre"
     *   stat_1_valeur   → "Stat 1 — Valeur"
     *   setting_colonnes → "⚙️ Colonnes"
     *   cta_texte       → "CTA — Texte"
     *   _brick_type     → "🏷️ Type de brique"
     */
    private function generateLabel(string $key): string
    {
        // Meta
        $metaLabels = [
            '_brick_type' => 'Type de brique',
            '_brick_name' => 'Nom de la brique',
            '_visible'    => 'Visible',
            '_order'      => 'Ordre',
        ];

        if (isset($metaLabels[$key])) {
            return $metaLabels[$key];
        }

        // Settings
        if (str_starts_with($key, 'setting_')) {
            $rest = substr($key, 8);
            return '⚙️ ' . Str::ucfirst(str_replace('_', ' ', $rest));
        }

        // CTA
        if (preg_match('/^cta(\d?)_(.+)$/', $key, $m)) {
            $num = $m[1] ? " {$m[1]}" : '';
            $field = Str::ucfirst(str_replace('_', ' ', $m[2]));
            return "CTA{$num} — {$field}";
        }

        // Bouton
        if (preg_match('/^bouton(\d?)_(.+)$/', $key, $m)) {
            $num = $m[1] ? " {$m[1]}" : '';
            $field = Str::ucfirst(str_replace('_', ' ', $m[2]));
            return "Bouton{$num} — {$field}";
        }

        // Clés indexées : prefix_N_champ → "Prefix N — Champ"
        if (preg_match('/^(.+?)_(\d+)_(.+)$/', $key, $m)) {
            $prefix = Str::ucfirst(str_replace('_', ' ', $m[1]));
            $num = $m[2];
            $field = Str::ucfirst(str_replace('_', ' ', $m[3]));
            return "{$prefix} {$num} — {$field}";
        }

        // Clés indexées simples : prefix_N → "Prefix N"
        if (preg_match('/^(.+?)_(\d+)$/', $key, $m)) {
            $prefix = Str::ucfirst(str_replace('_', ' ', $m[1]));
            $num = $m[2];
            return "{$prefix} {$num}";
        }

        // Compteur : prefix_count → "Prefix (nombre)"
        if (preg_match('/^(.+?)_count$/', $key, $m)) {
            $prefix = Str::ucfirst(str_replace('_', ' ', $m[1]));
            return "{$prefix} (nombre)";
        }

        // Clé simple
        return Str::ucfirst(str_replace('_', ' ', $key));
    }

    /**
     * Vérifie si un tableau est indexé (liste) ou associatif.
     */
    private function isIndexedArray(array $arr): bool
    {
        if (empty($arr)) {
            return false;
        }
        return array_keys($arr) === range(0, count($arr) - 1);
    }

    /**
     * Insère ou met à jour une entrée page_contents (idempotent).
     */
    private function upsert(string $page, string $section, string $key, string $value, string $type, string $label): void
    {
        PageContent::updateOrCreate(
            [
                'page'    => $page,
                'section' => $section,
                'key'     => $key,
            ],
            [
                'value' => $value,
                'type'  => $type,
                'label' => $label,
            ]
        );

        $this->stats[$page] = ($this->stats[$page] ?? 0) + 1;
    }
}
