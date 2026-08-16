<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Raccourcit les meta_title / meta_description des articles qui dépassaient les
 * limites d'affichage des SERP (jusqu'à 103 caractères de titre et 201 de description,
 * relevés en production le 15/08/2026). Au-delà, Google tronque et réécrit lui-même.
 *
 * Seuls les champs META sont touchés : le `title` de l'article — donc le H1 et le
 * libellé affiché — reste inchangé, la valeur éditoriale des titres longs est conservée.
 * Les descriptions reprennent les informations déjà publiées, sans ajout de chiffre.
 */
return new class extends Migration
{
    /** @var array<string, array{title: string, description: string|null}> */
    private const META = [
        'historique-reglementation-bacs-epbd-france' => [
            'title' => "25 ans de réglementation BACS et EPBD | NeoGTB",
            'description' => "RT 2005, RT 2012, RE2020, directive EPBD, décret tertiaire, décret BACS : 25 ans de durcissement des exigences énergétiques dans le bâtiment tertiaire.",
        ],
        'temoignage-gtb-anticipee-retour-experience' => [
            'title' => "GTB anticipée : le retour d'expérience | NeoGTB",
            'description' => "Un directeur technique revient sur un déploiement GTB mené en 2025 sur un bâtiment de 220 kW : −22 % de consommation CVC et prime CEE encaissée.",
        ],
        'decret-bacs-2030-point-technique' => [
            'title' => "Décret BACS : classes, puissances, commissioning",
            'description' => "Puissance nominale utile, classification NF EN ISO 52120-1, monitoring, inspection périodique : le décret 2025-1343 décrypté pour les bureaux d'études.",
        ],
        'bacs-decret-tertiaire-liens-indissociables' => [
            'title' => "BACS et décret tertiaire : ce qui les relie",
            'description' => null,
        ],
        'batiments-tertiaires-collectivites-gtb-2030' => [
            'title' => "Collectivités : la GTB obligatoire en 2030",
            'description' => null,
        ],
        'pme-decret-bacs-2030-guide-pratique' => [
            'title' => "PME et décret BACS 2030 : le guide pratique",
            'description' => null,
        ],
        'decret-bacs-report-2030-officialise' => [
            'title' => "Décret BACS reporté à 2030 : l'essentiel",
            'description' => null,
        ],
        'primes-cee-2026-gtb-comment-en-profiter' => [
            'title' => "Primes CEE GTB 2026 : conditions et montants",
            'description' => "La fiche CEE BAT-TH-116 reste accessible en 2026 pour financer votre installation GTB : montants, conditions d'éligibilité et démarches à engager.",
        ],
        'gtb-2030-et-apres-prospective-batiment-intelligent' => [
            'title' => "GTB après 2030 : vers le bâtiment intelligent",
            'description' => "Au-delà de la conformité BACS : IA prédictive, jumeaux numériques, flexibilité énergétique et autoconsommation. Une prospective GTB pour les décideurs.",
        ],
        'guide-verification-batiment-decret-bacs' => [
            'title' => "Décret BACS : votre bâtiment est-il concerné ?",
            'description' => "En 4 étapes, identifiez votre situation réglementaire, trouvez la puissance CVC de votre bâtiment et sachez ce que vous devez faire, sans jargon technique.",
        ],
        'plan-action-conformite-bacs-2030' => [
            'title' => "Conformité BACS : le plan d'action en 12 mois",
            'description' => "Un rétroplanning mois par mois pour les bâtiments tertiaires de 70 à 290 kW : de l'audit initial au choix de l'intégrateur, chaque étape est détaillée.",
        ],
        'sources-officielles-decret-bacs-2030' => [
            'title' => "Décret BACS : les sources officielles vérifiées",
            'description' => "Legifrance, rt-re-batiment.gouv.fr, OPERAT, norme NF EN ISO 52120-1 (ex-EN 15232) : les sources de référence du décret BACS, vérifiées et commentées.",
        ],
        'decret-bacs-reporte-10-questions-cles' => [
            'title' => "Décret BACS reporté : 10 questions clés",
            'description' => null,
        ],
        'report-2030-piege-attentisme' => [
            'title' => "Report BACS 2030 : le piège de l'attentisme",
            'description' => "Le décret 2025-1343 est une bonne nouvelle, mais le décret tertiaire court toujours. Sanctions, dépréciation des actifs, surcoûts : les risques de l'inaction.",
        ],
        'report-gtb-2030-analyse-roi' => [
            'title' => "Report GTB à 2030 : l'analyse ROI chiffrée",
            'description' => "Reporter l'investissement GTB est tentant. Les chiffres disent l'inverse : 15 à 30 % d'économies, ROI de 2 à 4 ans, primes CEE accessibles dès maintenant.",
        ],
        'protocoles-communication-bacnet-knx-modbus' => [
            'title' => "BACnet, KNX, Modbus : les protocoles GTB",
            'description' => null,
        ],
    ];

    public function up(): void
    {
        foreach (self::META as $slug => $meta) {
            $update = ['meta_title' => $meta['title']];

            if ($meta['description'] !== null) {
                $update['meta_description'] = $meta['description'];
            }

            DB::table('posts')->where('slug', $slug)->update($update);
        }
    }

    public function down(): void
    {
        // Pas de restauration : les valeurs remplacées étaient tronquées en SERP.
        // Les titres éditoriaux d'origine restent disponibles dans posts.title.
    }
};
