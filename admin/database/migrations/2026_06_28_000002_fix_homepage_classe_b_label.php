<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Correction one-shot d'un libellé de page d'accueil resté en base (page_contents,
 * clé ligne_droite_2_texte) — complément des migrations 2026_06_18_000002 et
 * 2026_06_28_000001.
 *
 * « Classe B minimum conforme ISO 52120-1 » → « Classe B (niveau visé) conforme
 * ISO 52120-1 ». Le « minimum » présentait la classe B comme une obligation du
 * décret BACS, alors que le décret impose des FONCTIONS (art. R. 175-3) — la
 * classe B est le niveau couramment visé / la condition de la prime CEE.
 *
 * Ce contenu n'a pas de source git (édité via Filament) : appliqué directement
 * en prod le 2026-06-28, cette migration le rend reproductible (résilience si un
 * backup antérieur est restauré). Idempotente (strtr), no-op si déjà corrigé.
 */
return new class extends Migration
{
    private function pairs(): array
    {
        return [
            'Classe B minimum conforme ISO 52120-1'
                => 'Classe B (niveau visé) conforme ISO 52120-1',
        ];
    }

    public function up(): void
    {
        $pairs = $this->pairs();
        $fix = fn ($v) => is_string($v) && $v !== '' ? strtr($v, $pairs) : $v;

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

        if (Schema::hasTable('page_contents')) {
            foreach (DB::table('page_contents')->get() as $row) {
                if (! property_exists($row, 'value')) {
                    continue;
                }
                $new = $fix($row->value);
                if ($new !== $row->value) {
                    DB::table('page_contents')->where('id', $row->id)->update(['value' => $new]);
                }
            }
        }
    }

    public function down(): void
    {
        // Correction factuelle one-shot (classe ≠ conformité) — non réversible.
    }
};
