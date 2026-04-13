<?php

namespace App\Services;

use App\Models\PageContent;

class ContentBrickAdapter
{
    /**
     * Mapping singulier → pluriel pour les préfixes de tableaux.
     * Gère les cas irréguliers (avis → avis, cas → cas, etc.)
     */
    private static array $pluralMap = [
        'stat' => 'stats',
        'carte' => 'cartes',
        'question' => 'questions',
        'etape' => 'etapes',
        'avis' => 'avis',
        'point' => 'points',
        'compteur' => 'compteurs',
        'cas' => 'cas',
        'logo' => 'logos',
        'ligne_gauche' => 'lignes_gauche',
        'ligne_droite' => 'lignes_droite',
        'legende' => 'legende',
        'identite' => 'identite',
        'modele_eco' => 'modele_economique',
        'metrique' => 'metriques',
        'tag' => 'tags',
        'feature' => 'features',
    ];

    /**
     * Reconstruit la liste ordonnée de briques pour une page,
     * compatible avec la vue front/page.blade.php.
     * Retourne un array d'objets avec brick_type, content, settings, is_visible.
     */
    public static function buildBricks(string $pageSlug): array
    {
        $pageData = PageContent::getPageData($pageSlug);

        // Récupérer l'ordre des sections
        $sectionsOrder = isset($pageData['_meta']['sections_order'])
            ? explode(',', $pageData['_meta']['sections_order'])
            : array_keys(array_diff_key($pageData, ['_meta' => true]));

        $bricks = [];
        foreach ($sectionsOrder as $section) {
            $section = trim($section);
            if ($section === '_meta' || !isset($pageData[$section])) continue;

            $flatData = $pageData[$section];
            $brickType = $flatData['_brick_type'] ?? self::guessBrickType($section);

            $content = self::rebuildContent($flatData);
            $settings = self::extractSettings($flatData);

            $bricks[] = (object) [
                'brick_type' => $brickType,
                'brick_name' => $flatData['_brick_name'] ?? '',
                'content' => $content,
                'settings' => $settings,
                'is_visible' => ($flatData['_visible'] ?? '1') === '1',
            ];
        }

        return $bricks;
    }

    /**
     * Reconstruit le $content array à partir des clés plates.
     * Détecte les préfixes indexés (stat_1_*, carte_2_*) et les regroupe en tableaux.
     */
    private static function rebuildContent(array $flat): array
    {
        $content = [];
        $arrayPrefixes = [];

        // Première passe : identifier les préfixes de tableaux TOP-LEVEL via _count
        // On exclut les _count imbriqués (ex: cas_1_metrique_count) qui contiennent
        // un index numérique dans le préfixe — ceux-ci sont gérés par extractIndexedItem.
        foreach ($flat as $key => $value) {
            if (str_ends_with($key, '_count')) {
                $prefix = substr($key, 0, -6); // Remove '_count'
                // Exclure les préfixes contenant un segment numérique (= sous-tableau imbriqué)
                if (preg_match('/_\d+_/', $prefix . '_')) continue;
                $arrayPrefixes[$prefix] = (int) $value;
            }
        }

        // Deuxième passe : construire les scalaires et les tableaux
        $processedKeys = [];

        // Construire les tableaux indexés
        foreach ($arrayPrefixes as $prefix => $count) {
            $items = [];
            for ($i = 1; $i <= $count; $i++) {
                $item = self::extractIndexedItem($flat, $prefix, $i);
                if ($item !== null) {
                    $items[] = $item;
                }
            }
            $pluralKey = self::$pluralMap[$prefix] ?? $prefix . 's';
            $content[$pluralKey] = $items;

            // Marquer les clés comme traitées
            $processedKeys[] = "{$prefix}_count";
            for ($i = 1; $i <= $count; $i++) {
                foreach ($flat as $key => $val) {
                    if (preg_match("/^{$prefix}_{$i}_/", $key) || $key === "{$prefix}_{$i}") {
                        $processedKeys[] = $key;
                    }
                }
            }
        }

        // Ajouter les scalaires (clés non traitées, non settings, non meta)
        foreach ($flat as $key => $value) {
            if (in_array($key, $processedKeys)) continue;
            if (str_starts_with($key, 'setting_')) continue;
            if (str_starts_with($key, '_')) continue;
            $content[$key] = $value;
        }

        return $content;
    }

    /**
     * Extrait un item indexé.
     * Si les sous-clés existent (prefix_1_titre, prefix_1_desc), retourne un array associatif.
     * Sinon (prefix_1), retourne la valeur seule.
     *
     * Gère aussi :
     * - Les sous-tableaux indexés (prefix_N_subprefix_count + prefix_N_subprefix_M_field)
     * - Les sous-objets imbriqués (prefix_N_subobj_field regroupés en prefix_N.subobj = [...])
     */
    private static function extractIndexedItem(array $flat, string $prefix, int $index): mixed
    {
        $subFields = [];
        $simpleKey = "{$prefix}_{$index}";
        $itemPrefix = "{$prefix}_{$index}_";

        // Collecter toutes les sous-clés brutes (prefix_N_*)
        $rawSubFields = [];
        foreach ($flat as $key => $value) {
            if (str_starts_with($key, $itemPrefix)) {
                $remainder = substr($key, strlen($itemPrefix));
                $rawSubFields[$remainder] = $value;
            }
        }

        if (empty($rawSubFields)) {
            // Valeur simple (prefix_N)
            return $flat[$simpleKey] ?? null;
        }

        // Passe 1 : détecter les sous-tableaux indexés via _count
        $nestedArrayPrefixes = [];
        foreach ($rawSubFields as $remainder => $value) {
            if (str_ends_with($remainder, '_count') && is_numeric($value)) {
                $nestedPrefix = substr($remainder, 0, -6); // Remove '_count'
                $nestedArrayPrefixes[$nestedPrefix] = (int) $value;
            }
        }

        // Passe 2 : reconstruire les sous-tableaux indexés
        $processedRemainders = [];
        foreach ($nestedArrayPrefixes as $nestedPrefix => $count) {
            $items = [];
            for ($i = 1; $i <= $count; $i++) {
                // Chercher les sous-sous-clés (nestedPrefix_M_field)
                $nestedSubFields = [];
                $nestedItemKey = "{$nestedPrefix}_{$i}";
                $nestedItemPrefix = "{$nestedPrefix}_{$i}_";

                foreach ($rawSubFields as $remainder => $val) {
                    if (str_starts_with($remainder, $nestedItemPrefix)) {
                        $field = substr($remainder, strlen($nestedItemPrefix));
                        $nestedSubFields[$field] = $val;
                        $processedRemainders[] = $remainder;
                    } elseif ($remainder === $nestedItemKey) {
                        // Valeur simple (nestedPrefix_M sans sous-champ)
                        $nestedSubFields = $val;
                        $processedRemainders[] = $remainder;
                    }
                }

                if (is_array($nestedSubFields) && !empty($nestedSubFields)) {
                    $items[] = $nestedSubFields;
                } elseif (is_string($nestedSubFields)) {
                    $items[] = $nestedSubFields;
                }
            }

            $pluralKey = self::$pluralMap[$nestedPrefix] ?? $nestedPrefix . 's';
            $subFields[$pluralKey] = $items;
            $processedRemainders[] = "{$nestedPrefix}_count";
        }

        // Passe 3 : regrouper les sous-objets (ex: gauge_progress_from, gauge_active → gauge = [...])
        $subObjectFields = [];
        $simpleFields = [];
        foreach ($rawSubFields as $remainder => $value) {
            if (in_array($remainder, $processedRemainders)) continue;

            // Vérifier si c'est un sous-objet (contient _ et le premier segment n'est pas un index numérique)
            if (str_contains($remainder, '_')) {
                $parts = explode('_', $remainder, 2);
                $subObjName = $parts[0];
                $subObjField = $parts[1];

                // Vérifier que ce n'est pas un champ simple connu
                // Un sous-objet a au moins 2 clés avec le même préfixe
                $samePrefix = 0;
                foreach ($rawSubFields as $r => $v) {
                    if (in_array($r, $processedRemainders)) continue;
                    if (str_starts_with($r, $subObjName . '_')) $samePrefix++;
                }

                if ($samePrefix >= 2) {
                    $subObjectFields[$subObjName][$subObjField] = $value;
                } else {
                    $simpleFields[$remainder] = $value;
                }
            } else {
                $simpleFields[$remainder] = $value;
            }
        }

        // Ajouter les champs simples
        foreach ($simpleFields as $key => $val) {
            $subFields[$key] = $val;
        }

        // Ajouter les sous-objets
        foreach ($subObjectFields as $objName => $objFields) {
            $subFields[$objName] = $objFields;
        }

        return $subFields;
    }

    /**
     * Extrait les settings depuis les clés setting_*.
     */
    private static function extractSettings(array $flat): array
    {
        $settings = [];
        foreach ($flat as $key => $value) {
            if (str_starts_with($key, 'setting_')) {
                $settingKey = substr($key, 8); // Remove 'setting_'
                $settings[$settingKey] = $value;
            }
        }
        return $settings;
    }

    /**
     * Devine le brick_type à partir du nom de section.
     * "cartes--outils" → "cartes", "hero-image" → "hero-image"
     */
    private static function guessBrickType(string $section): string
    {
        $parts = explode('--', $section);
        return $parts[0];
    }
}
