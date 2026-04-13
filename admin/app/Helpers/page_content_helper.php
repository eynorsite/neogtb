<?php

use App\Models\PageContent;

if (!function_exists('page_content')) {
    /**
     * Récupère une valeur de contenu de page.
     * Usage : page_content('accueil', 'hero', 'titre', 'Fallback')
     */
    function page_content(string $page, string $section, string $key, mixed $default = null): mixed
    {
        $value = PageContent::getValue($page, $section, $key, $default);

        // Purifier le HTML si présent
        if (is_string($value) && $value !== strip_tags($value)) {
            return clean_html($value);
        }

        return $value;
    }
}

if (!function_exists('clean_html')) {
    /**
     * Nettoie le HTML pour prévenir XSS.
     */
    function clean_html(string $html): string
    {
        return strip_tags($html, '<br><strong><em><a><ul><ol><li><p><h2><h3><h4><span><div>');
    }
}
