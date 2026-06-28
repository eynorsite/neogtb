<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Correction factuelle one-shot du contenu en base (prod) — complément de la
 * migration 2026_06_18_000002 (mêmes tables, mêmes principes).
 *
 * Aligne le contenu DÉJÀ présent en base (chatbot, blog, configs — édité via
 * Filament, hors git) sur la nuance déjà appliquée au code (commit 2ae50205) :
 *   « le décret BACS impose des FONCTIONS (art. R. 175-3 du CCH), PAS une
 *     classe ». La classe B est le niveau couramment visé et la condition de
 *     la prime CEE ; la classe C reste conforme au décret.
 *
 * Cible les 7 formulations « classe B minimum / obligatoire / requise »
 * oubliées par la migration 000002 (base de connaissances du chatbot, 2 FAQ,
 * 3 articles de blog). Le blog est stocké en HTML : variantes <strong> + **md**
 * incluses pour les fragments en gras.
 *
 * Idempotente (strtr : aucune ré-application une fois les segments corrigés ;
 * no-op si la chaîne n'existe pas dans la table). Non destructive.
 */
return new class extends Migration
{
    private function pairs(): array
    {
        return [
            // ── Chatbot — base de connaissances (chatbot_knowledge_snippets.content)
            "Le système installé doit atteindre au minimum la classe B de la norme NF EN ISO 52120-1 (ex-EN 15232) et faire l'objet d'une inspection régulière."
                => "Le décret impose des fonctions d'automatisation (art. R. 175-3 du CCH), pas une classe : en pratique, la classe B de la norme NF EN ISO 52120-1 (ex-EN 15232) est le niveau couramment visé et la condition de la prime CEE. Le système fait l'objet d'une inspection régulière.",

            // ── Chatbot — FAQ (chatbot_faqs.answer)
            "Le décret BACS impose un système d'automatisation et de contrôle atteignant au minimum la classe B (NF EN ISO 52120-1), ce qui correspond à une GTB."
                => "Le décret BACS impose un système d'automatisation et de contrôle (ce qui correspond à une GTB) : il impose des fonctions (art. R. 175-3), pas une classe — en pratique, la classe B (NF EN ISO 52120-1) est le niveau couramment visé et la condition de la prime CEE.",

            // ── Offre conformité continue (FAQ — si répliquée en base/config)
            'Le décret BACS porte sur le système : il impose une GTB de classe A ou B capable de suivre, analyser et alerter en continu.'
                => "Le décret BACS porte sur le système : il impose des fonctions d'automatisation (art. R. 175-3) — en pratique une GTB de classe A ou B — capables de suivre, analyser et alerter en continu.",

            // ── Page réglementation (encart — si répliqué en base/config)
            'Classe A ou B requise.' => 'Classe B visée en pratique (condition CEE).',

            // ── Blog (posts.content, HTML) — gtb-2030 (sans gras)
            'Le décret BACS impose un plancher technique, la classe B de la norme NF EN ISO 52120-1.'
                => "Le décret BACS impose un plancher technique — des fonctions d'automatisation (art. R. 175-3), couramment satisfaites par une GTB de classe B (NF EN ISO 52120-1).",

            // ── Blog — décret tertiaire (fragment stable, sans dépendre des emojis)
            'Une GTB de classe B minimum répond à toutes les exigences : suivi'
                => 'Une GTB de classe B répond en pratique à toutes les fonctions exigées (art. R. 175-3) : suivi',

            // ── Blog — historique (gras : variantes HTML puis markdown puis fallback)
            'Renforcement des exigences de <strong>classe A</strong> (au lieu de B minimum) pour certaines catégories'
                => 'Renforcement probable du niveau visé (vers la <strong>classe A</strong>) pour certaines catégories',
            'Renforcement des exigences de **classe A** (au lieu de B minimum) pour certaines catégories'
                => 'Renforcement probable du niveau visé (vers la **classe A**) pour certaines catégories',
            ' (au lieu de B minimum)' => '',
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
        // Correction factuelle one-shot (classe ≠ conformité) — non réversible.
    }
};
