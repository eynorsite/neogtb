<?php

namespace App\Services;

use App\Models\GeneralSetting;

class HomepageSectionsService
{
    /**
     * Liste des sections supportées sur la homepage NeoGTB,
     * avec leur label d'affichage.
     */
    public function supportedSections(): array
    {
        return [
            'hero'         => 'Hero',
            'expertises'   => 'Expertises GTB',
            'chiffres'     => 'Chiffres clés',
            'comparatif'   => 'Comparatif GTB/GTC',
            'solutions'    => 'Solutions & Technologies',
            'temoignages'  => 'Témoignages',
            'faq'          => 'FAQ',
            'cta_audit'    => 'CTA Audit',
            'blog_recent'  => 'Articles récents',
        ];
    }

    /**
     * Récupère la configuration d'une section spécifique.
     */
    public function get(string $section): array
    {
        return GeneralSetting::get()->homepage_sections_config[$section] ?? [];
    }

    /**
     * Retourne les sections activées dans l'ordre défini,
     * chacune enrichie de sa configuration.
     */
    public function orderedSections(): array
    {
        $enabled = GeneralSetting::get()->homepage_sections ?? [];
        $supported = $this->supportedSections();

        $result = [];

        foreach ($enabled as $key) {
            if (! array_key_exists($key, $supported)) {
                continue;
            }

            $result[] = [
                'key'    => $key,
                'label'  => $supported[$key],
                'config' => $this->get($key),
            ];
        }

        return $result;
    }
}
