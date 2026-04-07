<?php

namespace App\Helpers;

class BlogCta
{
    /**
     * Retourne un CTA contextualisé selon les tags et la catégorie d'un article.
     *
     * @param  array<int, string>  $tags
     * @return array{title:string, description:string, link:string, linkText:string}
     */
    public static function for(array $tags, ?string $category): array
    {
        $default = [
            'title' => 'Un projet GTB à clarifier ?',
            'description' => 'Pré-diagnostic ISO 52120-1 gratuit en ligne, ou échange de 15 minutes pour cadrer votre besoin.',
            'link' => '/audit',
            'linkText' => 'Lancer le diagnostic',
        ];

        $bacs = [
            'title' => 'Êtes-vous concerné par le décret BACS ?',
            'description' => 'Testez votre conformité au décret BACS avec notre pré-diagnostic ISO 52120-1 en 3 minutes.',
            'link' => '/audit',
            'linkText' => 'Lancer le diagnostic',
        ];

        $cee = [
            'title' => 'Financez votre projet GTB avec les CEE',
            'description' => 'Estimez vos aides CEE pour votre projet GTB en quelques clics avec notre générateur.',
            'link' => '/generateur-cee',
            'linkText' => 'Estimer mes aides CEE',
        ];

        $comparateur = [
            'title' => 'Comparez les solutions GTB sans biais commercial',
            'description' => 'Comparez objectivement les protocoles et solutions GTB pour choisir la technologie adaptée à votre bâtiment.',
            'link' => '/comparateur',
            'linkText' => 'Comparer les solutions',
        ];

        $values = array_filter(array_merge($tags, $category ? [$category] : []), 'is_string');
        if (empty($values)) {
            return $default;
        }

        $normalize = static function (string $v): string {
            $v = mb_strtolower($v);
            $translit = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $v);
            return $translit !== false ? $translit : $v;
        };

        $haystack = implode(' ', array_map($normalize, $values));

        if (preg_match('/bacs|reglementation|decret/', $haystack)) {
            return $bacs;
        }
        if (preg_match('/cee|economies|aides|financement|prime/', $haystack)) {
            return $cee;
        }
        if (preg_match('/comparatif|comparateur|marques|fabricant|fournisseur/', $haystack)) {
            return $comparateur;
        }

        return $default;
    }
}
