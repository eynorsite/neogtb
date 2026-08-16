<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Répercute en base les titres/descriptions raccourcis de StaticPageController::DEFAULT_SEO.
 *
 * SitePage.meta_* prime sur DEFAULT_SEO (repli filled() dans le contrôleur) : sans cette
 * migration, la base continuerait de servir les valeurs longues alignées en juin 2026
 * et la correction du code resterait invisible en production.
 *
 * Garde-fou : on ne remplace QUE si la valeur en base est encore, au caractère près,
 * l'ancienne valeur du code. Toute personnalisation saisie depuis dans Filament est
 * donc préservée — une migration de contenu ne doit jamais écraser une saisie humaine.
 */
return new class extends Migration
{
    /** @var array<string, array{old: string, new: string, field: string}> */
    private const REPLACEMENTS = [
        'decret-bacs.title' => [
            'field' => 'meta_title',
            'slug' => 'decret-bacs',
            'old' => "Décret BACS : qui est concerné, échéances, mise en conformité | NeoGTB",
            'new' => "Décret BACS : qui est concerné et à quelle échéance",
        ],
        'decret-bacs.description' => [
            'field' => 'meta_description',
            'slug' => 'decret-bacs',
            'old' => "Décret BACS : GTB de classe B (NF EN ISO 52120-1) en pratique. Bâtiments concernés, échéances, dérogation TRI > 10 ans, CEE BAT-TH-116 et accompagnement indépendant.",
            'new' => "Décret BACS : bâtiments concernés, échéances, dérogation TRI > 10 ans, GTB de classe B (NF EN ISO 52120-1) et prime CEE BAT-TH-116 en pratique.",
        ],
        'modele-cctp-decret-bacs.description' => [
            'field' => 'meta_description',
            'slug' => 'modele-cctp-decret-bacs',
            'old' => "Modèle type de CCTP GTB conforme au décret BACS : objet, cadre réglementaire, exigences fonctionnelles classe B (NF EN ISO 52120-1), protocoles, cybersécurité. Neutre fabricant.",
            'new' => "Modèle type de CCTP GTB conforme au décret BACS : cadre réglementaire, exigences classe B (NF EN ISO 52120-1), protocoles, cybersécurité. Neutre fabricant.",
        ],
        'amo-gtb-gtc.title' => [
            'field' => 'meta_title',
            'slug' => 'amo-gtb-gtc',
            'old' => "AMO GTB/GTC, Assistance maîtrise d'ouvrage indépendante | NeoGTB",
            'new' => "AMO GTB/GTC : maîtrise d'ouvrage indépendante",
        ],
        'positionnement.title' => [
            'field' => 'meta_title',
            'slug' => 'positionnement',
            'old' => "Pourquoi NeoGTB, Conseil GTB 100 % indépendant, sans commission",
            'new' => "Conseil GTB 100 % indépendant, sans commission",
        ],
        'solutions.title' => [
            'field' => 'meta_title',
            'slug' => 'solutions',
            'old' => "Solutions GTB : protocoles BACnet, KNX, Modbus, LON, Comparatif",
            'new' => "Solutions GTB : BACnet, KNX, Modbus, LON comparés",
        ],
    ];

    public function up(): void
    {
        foreach (self::REPLACEMENTS as $r) {
            // updated_at volontairement NON touché : une meta description n'est pas une
            // modification de contenu, et <lastmod> du sitemap doit rester crédible.
            DB::table('site_pages')
                ->where('slug', $r['slug'])
                ->whereNull('deleted_at')
                ->where($r['field'], $r['old'])
                ->update([$r['field'] => $r['new']]);
        }
    }

    public function down(): void
    {
        foreach (self::REPLACEMENTS as $r) {
            DB::table('site_pages')
                ->where('slug', $r['slug'])
                ->whereNull('deleted_at')
                ->where($r['field'], $r['new'])
                ->update([$r['field'] => $r['old']]);
        }
    }
};
