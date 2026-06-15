<?php

namespace App\Console\Commands;

use App\Models\ChatbotKnowledgeSnippet;
use App\Models\GeneralSetting;
use App\Models\PageContent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * Purge le contenu fabriqué / non vérifiable (règle R1) :
 *  - faux témoignages (noms d'entreprises empruntés)
 *  - compteurs de preuve sociale inventés (150+ bâtiments, 80+ clients, 340+ diagnostics…)
 *  - claims présentés comme des résultats clients (« 23 % en moyenne »)
 *
 * Idempotente : ne réécrit que ce qui diffère de la cible vérifiable ; relancée sur une base
 * déjà propre, elle ne fait AUCUNE écriture. Ne crée jamais une clé absente (R1 : pas de
 * structure inventée). Option --dry-run pour prévisualiser sans rien modifier.
 *
 * Usage prod : sudo -u www-data php artisan neogtb:purge-fake --dry-run  (puis sans --dry-run)
 */
class PurgeFake extends Command
{
    protected $signature = 'neogtb:purge-fake {--dry-run : Affiche les changements sans rien écrire}';

    protected $description = 'Purge R1 : faux témoignages, compteurs inventés et claims non vérifiables (général_settings, page_contents accueil, snippet chatbot).';

    private array $changes = [];

    private bool $dry = false;

    public function handle(): int
    {
        $this->dry = (bool) $this->option('dry-run');

        $this->purgeGeneralSettings();
        $this->purgeAccueilPageContents();
        $this->purgeChatbotSnippet();

        if (empty($this->changes)) {
            $this->info('Base déjà propre — aucun contenu fabriqué détecté. ✅');

            return self::SUCCESS;
        }

        if (! $this->dry) {
            Artisan::call('cache:clear');
            $this->changes[] = 'cache applicatif vidé (cache:clear)';
        }

        $this->newLine();
        foreach ($this->changes as $c) {
            $this->line(($this->dry ? '  <comment>[dry]</comment> ' : '  <info>✓</info> ').$c);
        }
        $this->newLine();
        $this->info(($this->dry ? '[DRY-RUN] ' : '').count($this->changes).' modification(s).');
        if ($this->dry) {
            $this->warn('Aucune écriture effectuée. Relancez SANS --dry-run pour appliquer.');
        }

        return self::SUCCESS;
    }

    /** general_settings : colonnes scalaires + JSON homepage_sections_config. */
    private function purgeGeneralSettings(): void
    {
        $gs = GeneralSetting::query()->first();
        if (! $gs) {
            return;
        }

        // a) Compteurs scalaires de preuve sociale.
        $scalars = [
            'stat_buildings_audited' => 0,    // 0 = masqué côté front (filtre 0=vide)
            'stat_years_experience' => null,
            'stat_clients_count' => null,
            // stat_avg_savings_percent : INCHANGÉ (35 défendable ISO 52120-1 ; seul le label admin change, en code)
        ];
        foreach ($scalars as $col => $target) {
            if ($gs->{$col} !== $target) {
                $this->changes[] = "general_settings.$col : ".var_export($gs->{$col}, true).' → '.var_export($target, true);
                if (! $this->dry) {
                    $gs->{$col} = $target;
                }
            }
        }

        // b) homepage_sections_config (cast array).
        $cfg = is_array($gs->homepage_sections_config) ? $gs->homepage_sections_config : [];
        $before = $cfg;

        // Témoignages : aucun avis inventé tant qu'il n'y a pas de vrai client.
        if (! empty(data_get($cfg, 'temoignages.avis'))) {
            $n = count(data_get($cfg, 'temoignages.avis'));
            data_set($cfg, 'temoignages.avis', []);
            $this->changes[] = "general_settings…temoignages.avis : $n faux témoignage(s) supprimé(s)";
        }

        // Chiffres clés : valeurs vérifiables (alignées sur le seeder).
        $verifiedStats = [
            ['valeur' => '0 €', 'label' => 'Commission fabricant, jamais'],
            ['valeur' => '10+', 'label' => 'Marques évaluées sans lien commercial'],
            ['valeur' => '48 h', 'label' => 'Réponse à votre demande'],
            ['valeur' => '100 %', 'label' => 'Indépendant'],
        ];
        if (data_get($cfg, 'chiffres.stats') !== null && data_get($cfg, 'chiffres.stats') != $verifiedStats) {
            data_set($cfg, 'chiffres.stats', $verifiedStats);
            $this->changes[] = 'general_settings…chiffres.stats : compteurs inventés → valeurs vérifiables';
        }

        // Cas-usage (expertises) : étiqueter le 1er cas comme illustratif.
        if (data_get($cfg, 'expertises.cas.0')) {
            $meta = 'Scénario-type illustratif · Bureau ~5 000 m²';
            if (data_get($cfg, 'expertises.cas.0.meta') !== $meta) {
                data_set($cfg, 'expertises.cas.0.meta', $meta);
                $this->changes[] = 'general_settings…expertises.cas[0].meta → « scénario-type illustratif »';
            }
        }

        if ($cfg !== $before && ! $this->dry) {
            $gs->homepage_sections_config = $cfg;
        }

        if (! $this->dry && $gs->isDirty()) {
            $gs->save();
        }
    }

    /** page_contents (page=accueil) : cta-counter, hero-image, cas-usage. */
    private function purgeAccueilPageContents(): void
    {
        // a) cta-counter : 1 seul compteur honnête (0 € commission), suppression des inventés.
        $this->setPC('accueil', 'cta-counter', 'compteur_1_valeur', '0 €');
        $this->setPC('accueil', 'cta-counter', 'compteur_1_label', 'commission fabricant, jamais');
        $this->setPC('accueil', 'cta-counter', 'compteur_1_couleur', 'accent');
        $this->delPC('accueil', 'cta-counter', [
            'compteur_2_valeur', 'compteur_2_label', 'compteur_2_couleur',
            'compteur_3_valeur', 'compteur_3_label', 'compteur_3_couleur',
            'compteur_4_valeur', 'compteur_4_label', 'compteur_4_couleur',
        ]);
        $this->setPC('accueil', 'cta-counter', 'compteur_count', '1');
        $this->setPC('accueil', 'cta-counter', 'eyebrow', 'Notre engagement');

        // b) hero-image : « 23 % en moyenne » (résultat client fabriqué) → formulation normative.
        $this->setPC('accueil', 'hero-image', 'description', "Pré-diagnostic ISO 52120-1 gratuit, comparateur de solutions sans biais commercial. La norme estime le passage d'un bâtiment de classe D à B à environ 25 % d'économies d'énergie globales.");
        $this->setPC('accueil', 'hero-image', 'stat_1_valeur', '~25 %');
        $this->setPC('accueil', 'hero-image', 'stat_1_label', "d'économies estimées (D→B, norme ISO 52120-1)");

        // c) cas-usage : retirer « résultats mesurables », étiqueter illustratif.
        $this->setPC('accueil', 'cas-usage', 'eyebrow', 'Scénarios-types');
        $this->setPC('accueil', 'cas-usage', 'titre', 'Des cas-types illustratifs, pour situer la démarche');
        $this->setPC('accueil', 'cas-usage', 'cas_1_metrique_1_label', 'réduction conso visée (objectif)');
        $this->setPC('accueil', 'cas-usage', 'cas_1_metrique_2_label', 'délai cahier des charges (estimé)');
    }

    /** Met à jour une paire page_contents UNIQUEMENT si la clé existe et diffère (jamais de création). */
    private function setPC(string $page, string $section, string $key, string $value): void
    {
        $row = PageContent::where(compact('page', 'section', 'key'))->first();
        if (! $row || $row->value === $value) {
            return;
        }
        $this->changes[] = "page_contents[$page/$section/$key] : « ".mb_strimwidth((string) $row->value, 0, 38, '…').' » → « '.mb_strimwidth($value, 0, 38, '…').' »';
        if (! $this->dry) {
            $row->value = $value;
            $row->save();
        }
    }

    /** Supprime des clés page_contents (compteurs inventés). */
    private function delPC(string $page, string $section, array $keys): void
    {
        $q = PageContent::where('page', $page)->where('section', $section)->whereIn('key', $keys);
        $n = (clone $q)->count();
        if ($n === 0) {
            return;
        }
        $this->changes[] = "page_contents[$page/$section] : suppression de $n clé(s) de compteurs inventés";
        if (! $this->dry) {
            $q->delete();
        }
    }

    /** Snippet chatbot « Décret BACS » : corrige les dates obsolètes. */
    private function purgeChatbotSnippet(): void
    {
        $snip = ChatbotKnowledgeSnippet::where('title', "Décret BACS — l'essentiel")->first();
        if (! $snip) {
            return;
        }
        $content = (string) $snip->content;
        if (! str_contains($content, '30 décembre 2025') && ! str_contains($content, "jusqu'en 2027")) {
            return;
        }
        $target = "Le décret BACS (décret n° 2020-887 du 20 juillet 2020) impose une GTB dans les bâtiments tertiaires non résidentiels selon la puissance des systèmes CVC. ".
            "Le décret n° 2025-1343 du 26 décembre 2025 a reporté l'échéance de la tranche 70 à 290 kW du 1er janvier 2027 au 1er janvier 2030 ".
            "(l'obligation au-delà de 290 kW reste en vigueur depuis le 1er janvier 2025). ".
            'Source : Légifrance, articles R. 175-1 et suivants du Code de la construction et de l\'habitation.';
        $this->changes[] = 'chatbot_knowledge_snippets[Décret BACS] : dates obsolètes corrigées (26 déc. 2025, report 2030)';
        if (! $this->dry) {
            $snip->content = $target;
            $snip->save();
        }
    }
}
