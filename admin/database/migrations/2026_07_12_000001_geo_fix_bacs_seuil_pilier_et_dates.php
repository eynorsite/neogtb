<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * Corrections factuelles GEO/SEO one-shot du contenu en base (prod) :
 *
 *  1. Article pilier « guide-complet-gtb-2026 » : le seuil du décret BACS y est
 *     décrit en SURFACE (« bâtiments tertiaires > 1 000 m² d'ici 2025 »), ce qui
 *     est FAUX. Le décret BACS s'exprime en PUISSANCE (art. R. 175-3 du CCH) :
 *     > 290 kW depuis 2025, puis 70 kW au 1er janvier 2030.
 *
 *  2. Article « decret-tertiaire-gtb-obligations » : l'échéance des bâtiments
 *     70–290 kW y est datée « 2027 », valeur périmée depuis le décret n° 2025-1343
 *     (26 déc. 2025) qui l'a reportée au 1er janvier 2030.
 *
 * Migration écrite SANS accès à la base de prod : les motifs sont donc tolérants
 * (espaces insécables, &nbsp;, &gt;/>, m²/m2) et IDEMPOTENTS (aucune ré-application
 * une fois corrigé). En cas de non-correspondance exacte → NO-OP sûr (jamais de
 * corruption). Le nombre de remplacements est journalisé (storage/logs) pour être
 * vérifié dans les logs de déploiement.
 *
 * Tables couvertes : idem migrations de correction précédentes.
 */
return new class extends Migration
{
    /** @return array<int, array{pattern: string, replace: string, label: string}> */
    private function rules(): array
    {
        return [
            [
                'label' => 'BACS seuil surface→puissance (pilier)',
                'pattern' => '/dans les bâtiments tertiaires\s*(?:&gt;|>|›)?\s*1(?:[\s\x{00a0}]|&nbsp;)*000\s*m\s*(?:²|2|&sup2;)\s*d[\x{2019}\x{0027}]ici\s*2025/iu',
                'replace' => 'pour les bâtiments tertiaires dont la puissance CVC dépasse 290 kW (depuis 2025), puis 70 kW (2030)',
            ],
            [
                'label' => 'BACS échéance 70 kW 2027→2030 (décret tertiaire)',
                'pattern' => '/(1\s*(?:er|ᵉʳ|<sup>er<\/sup>)?\s*janvier\s*)2027(\s*:?\s*bâtiments\s+avec\s+CVC\s*(?:&gt;|>)?\s*70\s*kW)/iu',
                'replace' => '${1}2030${2}',
            ],
        ];
    }

    public function up(): void
    {
        $rules = $this->rules();
        $counts = array_fill_keys(array_column($rules, 'label'), 0);

        $apply = function (?string $value) use ($rules, &$counts): ?string {
            if (! is_string($value) || $value === '') {
                return $value;
            }
            foreach ($rules as $rule) {
                $new = preg_replace($rule['pattern'], $rule['replace'], $value, -1, $n);
                if ($new !== null && $n > 0) {
                    $counts[$rule['label']] += $n;
                    $value = $new;
                }
            }

            return $value;
        };

        // general_settings : 1 ligne, colonnes de contenu (configs JSON incluses)
        if (Schema::hasTable('general_settings') && ($gs = DB::table('general_settings')->first())) {
            $update = [];
            foreach ((array) $gs as $col => $val) {
                if (in_array($col, ['id', 'created_at', 'updated_at'], true)) {
                    continue;
                }
                $new = $apply($val);
                if ($new !== $val) {
                    $update[$col] = $new;
                }
            }
            if ($update) {
                DB::table('general_settings')->where('id', $gs->id)->update($update);
            }
        }

        // Tables ligne-par-ligne : [table => [colonnes texte]]
        $tables = [
            'posts' => ['content', 'excerpt'],
            'page_contents' => ['value'],
            'chatbot_knowledge_snippets' => ['content'],
            'chatbot_faqs' => ['question', 'answer'],
        ];

        foreach ($tables as $table => $cols) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            foreach (DB::table($table)->get() as $row) {
                $update = [];
                foreach ($cols as $col) {
                    if (! property_exists($row, $col)) {
                        continue;
                    }
                    $new = $apply($row->$col);
                    if ($new !== $row->$col) {
                        $update[$col] = $new;
                    }
                }
                if ($update) {
                    DB::table($table)->where('id', $row->id)->update($update);
                }
            }
        }

        Log::info('[GEO migration] Corrections BACS appliquées', $counts);
    }

    public function down(): void
    {
        // Corrections factuelles one-shot (seuil BACS en puissance ; échéance 2030) — non réversibles.
    }
};
