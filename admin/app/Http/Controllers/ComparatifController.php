<?php

namespace App\Http\Controllers;

/**
 * Pages comparatives GEO (config-driven).
 *
 * Une route + ce contrôleur + la vue front.comparatif, pilotés par
 * config/comparatifs-gtb.php. Chaque slug y est défini avec son tableau,
 * ses cartes "quand choisir" et sa FAQ. Le schéma FAQPage JSON-LD est
 * poussé par la vue via @push('schema') (même mécanisme que /faq).
 */
class ComparatifController extends Controller
{
    public function show(string $slug)
    {
        $cfg = config("comparatifs-gtb.$slug");

        abort_if(blank($cfg), 404);

        // Maillage interne : les AUTRES comparatifs disponibles.
        $others = [];
        foreach (config('comparatifs-gtb', []) as $otherSlug => $otherCfg) {
            if ($otherSlug === $slug) {
                continue;
            }
            $others[] = [
                'slug'  => $otherSlug,
                'title' => $otherCfg['title'] ?? $otherSlug,
                'lede'  => $otherCfg['lede'] ?? '',
            ];
        }

        return view('front.comparatif', [
            'cfg'    => $cfg,
            'slug'   => $slug,
            'others' => $others,
            // SEO injecté dans le layout (cf. front.layouts.app).
            'seoTitle'       => $cfg['meta_title'],
            'seoDescription' => $cfg['meta_description'],
        ]);
    }
}
