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
            'theme_primary_color'   => '#1E3A5F',
            'theme_secondary_color' => '#2D5F8A',
            'theme_accent_color'    => '#F59E0B',
            'theme_header_bg'       => '#0F172A',
            'theme_header_text'     => '#F8FAFC',
            'theme_footer_bg'       => '#1E293B',
            'theme_footer_text'     => '#CBD5E1',
            'theme_body_bg'         => '#FFFFFF',
            'theme_hero_overlay'    => '#0F172A',
            'theme_hero_opacity'    => '60',
            'theme_cta_bg'          => '#F59E0B',
            'theme_cta_text'        => '#0F172A',
        ],
        'eco_green' => [
            'theme_primary_color'   => '#065F46',
            'theme_secondary_color' => '#10B981',
            'theme_accent_color'    => '#F59E0B',
            'theme_header_bg'       => '#064E3B',
            'theme_header_text'     => '#ECFDF5',
            'theme_footer_bg'       => '#065F46',
            'theme_footer_text'     => '#A7F3D0',
            'theme_body_bg'         => '#F0FDF4',
            'theme_hero_overlay'    => '#064E3B',
            'theme_hero_opacity'    => '50',
            'theme_cta_bg'          => '#10B981',
            'theme_cta_text'        => '#FFFFFF',
        ],
        'tech_blue' => [
            'theme_primary_color'   => '#2563EB',
            'theme_secondary_color' => '#3B82F6',
            'theme_accent_color'    => '#06B6D4',
            'theme_header_bg'       => '#1E1B4B',
            'theme_header_text'     => '#E0E7FF',
            'theme_footer_bg'       => '#1E1B4B',
            'theme_footer_text'     => '#C7D2FE',
            'theme_body_bg'         => '#F8FAFC',
            'theme_hero_overlay'    => '#1E1B4B',
            'theme_hero_opacity'    => '55',
            'theme_cta_bg'          => '#2563EB',
            'theme_cta_text'        => '#FFFFFF',
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
