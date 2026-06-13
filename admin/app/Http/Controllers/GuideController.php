<?php

namespace App\Http\Controllers;

/**
 * Pages-guides GEO (piliers, config-driven).
 *
 * Pendant du système comparatif : une route + ce contrôleur + la vue
 * front.guide, pilotés par config/guides-gtb.php. Chaque slug y est défini
 * avec ses tableaux génériques (N colonnes), une note, des cartes et sa FAQ.
 * Le schéma FAQPage JSON-LD est poussé par la vue via @push('schema').
 */
class GuideController extends Controller
{
    public function show(string $slug)
    {
        $cfg = config("guides-gtb.$slug");

        abort_if(blank($cfg), 404);

        // Maillage interne : les AUTRES guides disponibles.
        $others = [];
        foreach (config('guides-gtb', []) as $otherSlug => $otherCfg) {
            if ($otherSlug === $slug) {
                continue;
            }
            $others[] = [
                'slug' => $otherSlug,
                'title' => $otherCfg['title'] ?? $otherSlug,
                'lede' => $otherCfg['lede'] ?? '',
            ];
        }

        return view('front.guide', [
            'cfg' => $cfg,
            'slug' => $slug,
            'others' => $others,
            // SEO injecté dans le layout (cf. front.layouts.app).
            'seoTitle' => $cfg['meta_title'],
            'seoDescription' => $cfg['meta_description'],
        ]);
    }
}
