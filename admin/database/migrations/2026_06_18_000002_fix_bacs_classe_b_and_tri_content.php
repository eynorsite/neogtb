<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Correction factuelle one-shot du contenu en base (prod) :
 *  - « le décret BACS impose/exige la classe B » → FAUX. Le décret impose des
 *    FONCTIONS (art. R. 175-3 du CCH) ; la classe B est le niveau couramment
 *    visé et la condition de la prime CEE (BAT-TH-116) ; la classe C reste
 *    conforme au décret.
 *  - Dérogation : temps de retour sur investissement « > 6 ans » → « > 10 ans »
 *    (valeur exacte de l'art. R. 175-2 du CCH, vérifiée sur Légifrance).
 *
 * Le code (seeders, blades, configs) est déjà corrigé ; cette migration aligne
 * le contenu déjà présent en base (édité via Filament, hors git). Idempotente
 * (strtr : aucune ré-application si les segments ont déjà été corrigés).
 */
return new class extends Migration
{
    private function pairs(): array
    {
        return [
            // Dérogation TRI : 6 → 10 ans (art. R. 175-2)
            'supérieur à 6 ans' => 'supérieur à 10 ans',
            'dépasse 6 ans' => 'dépasse 10 ans',
            'retour sur investissement > 6 ans' => 'retour sur investissement > 10 ans',
            '> 6 ans' => '> 10 ans',

            // FAQ (faq_page_config)
            'vous devez avoir un système BACS de classe B minimum depuis le 1er janvier 2025'
                => 'vous êtes concerné depuis le 1er janvier 2025',
            "c'est le niveau requis par le décret BACS"
                => 'niveau couramment visé et condition de la prime CEE',
            'automatisation standard, le minimum.'
                => 'automatisation standard, conforme au décret BACS.',

            // Home (homepage_sections_config / page_contents)
            'Classe B min.' => 'Classe B',
            'exigence décret BACS (ISO 52120-1)' => 'niveau visé / condition CEE (ISO 52120-1)',
            'BACS classe B min.' => 'BACS (classe B visée)',
            'cible exigée par le décret BACS' => 'cible visée (condition CEE)',

            // Page GTB
            "Impose un système d'automatisation (classe B min.) pour les bâtiments tertiaires."
                => "Impose un système d'automatisation pour les bâtiments tertiaires (classe B en pratique).",

            // Page réglementation
            'Impose une GTB de classe B minimum (ISO 52120-1) capable de suivre, analyser et piloter les consommations CVC.'
                => "Impose des fonctions d'automatisation (art. R. 175-3) ; la classe B (ISO 52120-1) est le niveau visé pour suivre, analyser et piloter les consommations CVC.",
            'B avancé (exigence BACS)' => 'B avancé (niveau visé / condition CEE)',

            // Page comparateur
            'Capacité à atteindre la classe B exigée par le décret BACS.'
                => 'Capacité à atteindre la classe B (niveau visé / condition CEE).',

            // Chatbot
            "C'est le niveau MINIMUM exigé par le décret BACS."
                => "C'est le niveau couramment visé et la condition de la prime CEE.",
            'Le décret BACS impose donc la classe B a minima. Les classes A et B ouvrent droit à la prime CEE BAT-TH-116.'
                => 'Le décret BACS impose des fonctions (art. R. 175-3 du CCH), pas une classe : la classe C reste conforme au décret. Les classes A et B ouvrent droit à la prime CEE BAT-TH-116.',
            'automatisation standard (référence de base).' => 'automatisation standard (conforme au décret BACS).',
            "l'obligation d'installer une GTB de classe B minimum s'applique au 1er janvier 2030"
                => "l'obligation d'installer une GTB s'applique au 1er janvier 2030",

            // Blog
            'avec les exigences de classe B minimum, la compatibilité OPERAT'
                => 'visant la classe B (condition de la prime CEE), la compatibilité OPERAT',
        ];
    }

    public function up(): void
    {
        $pairs = $this->pairs();
        $fix = fn ($v) => is_string($v) && $v !== '' ? strtr($v, $pairs) : $v;

        // general_settings : 1 ligne, nombreuses colonnes de contenu (configs JSON)
        if (Schema::hasTable('general_settings') && ($gs = DB::table('general_settings')->first())) {
            $update = [];
            foreach ((array) $gs as $col => $val) {
                if (in_array($col, ['id', 'created_at', 'updated_at'], true)) {
                    continue;
                }
                $new = $fix($val);
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
            'page_contents' => ['value'],
            'chatbot_knowledge_snippets' => ['content'],
            'chatbot_faqs' => ['question', 'answer'],
            'posts' => ['content', 'excerpt'],
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
                    $new = $fix($row->$col);
                    if ($new !== $row->$col) {
                        $update[$col] = $new;
                    }
                }
                if ($update) {
                    DB::table($table)->where('id', $row->id)->update($update);
                }
            }
        }
    }

    public function down(): void
    {
        // Correction factuelle one-shot (classe ≠ conformité ; TRI art. R. 175-2) — non réversible.
    }
};
