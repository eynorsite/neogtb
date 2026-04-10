<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Domaine canonique
    |--------------------------------------------------------------------------
    */
    'canonical_domain' => env('CANONICAL_DOMAIN', 'neogtb.fr'),

    /*
    |--------------------------------------------------------------------------
    | Presets de thème
    |--------------------------------------------------------------------------
    */
    'presets' => [
        'gtb_pro' => [
            'primary_color'       => '#1E3A5F',
            'secondary_color'     => '#2D5F8A',
            'accent_color'        => '#F59E0B',
            'header_bg_color'     => '#0F172A',
            'header_text_color'   => '#F8FAFC',
            'footer_bg_color'     => '#1E293B',
            'footer_text_color'   => '#CBD5E1',
            'body_bg_color'       => '#FFFFFF',
            'hero_overlay_color'  => '#0F172A',
            'hero_overlay_opacity' => 60,
            'cta_bg_color'        => '#F59E0B',
            'cta_text_color'      => '#0F172A',
        ],
        'eco_green' => [
            'primary_color'       => '#065F46',
            'secondary_color'     => '#10B981',
            'accent_color'        => '#F59E0B',
            'header_bg_color'     => '#064E3B',
            'header_text_color'   => '#ECFDF5',
            'footer_bg_color'     => '#065F46',
            'footer_text_color'   => '#A7F3D0',
            'body_bg_color'       => '#F0FDF4',
            'hero_overlay_color'  => '#064E3B',
            'hero_overlay_opacity' => 50,
            'cta_bg_color'        => '#10B981',
            'cta_text_color'      => '#FFFFFF',
        ],
        'tech_blue' => [
            'primary_color'       => '#2563EB',
            'secondary_color'     => '#3B82F6',
            'accent_color'        => '#06B6D4',
            'header_bg_color'     => '#1E1B4B',
            'header_text_color'   => '#E0E7FF',
            'footer_bg_color'     => '#1E1B4B',
            'footer_text_color'   => '#C7D2FE',
            'body_bg_color'       => '#F8FAFC',
            'hero_overlay_color'  => '#1E1B4B',
            'hero_overlay_opacity' => 55,
            'cta_bg_color'        => '#2563EB',
            'cta_text_color'      => '#FFFFFF',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | RGPD — Rétention minimale (jours)
    |--------------------------------------------------------------------------
    | Plancher en dur : la valeur admin ne peut pas descendre en dessous.
    */
    'rgpd_min_retention' => [
        'contacts'   => 90,
        'leads'      => 90,
        'cookies'    => 30,
        'newsletter' => 90,
    ],

];
