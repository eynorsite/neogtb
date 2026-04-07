<?php

namespace App\Filament\Bricks;

use App\Filament\Bricks\Content\BrickHero;
use App\Filament\Bricks\Content\BrickHeroImage;
use App\Filament\Bricks\Content\BrickTexte;
use App\Filament\Bricks\Content\BrickCTA;
use App\Filament\Bricks\Content\BrickCtaCounter;
use App\Filament\Bricks\Content\BrickCtaIllustrated;
use App\Filament\Bricks\Content\BrickCartes;
use App\Filament\Bricks\Content\BrickCartesPositioning;
use App\Filament\Bricks\Content\BrickCartesArticles;
use App\Filament\Bricks\Content\BrickChiffres;
use App\Filament\Bricks\Content\BrickComparatif;
use App\Filament\Bricks\Content\BrickFormulaire;
use App\Filament\Bricks\Content\BrickFAQ;
use App\Filament\Bricks\Content\BrickTemoignages;
use App\Filament\Bricks\Content\BrickMethodologie;
use App\Filament\Bricks\Content\BrickTimeline;
use App\Filament\Bricks\Content\BrickFondateur;
use App\Filament\Bricks\Content\BrickCasUsage;
use App\Filament\Bricks\Structure\BrickBandeau;
use App\Filament\Bricks\Structure\BrickLogos;
use App\Filament\Bricks\Structure\BrickSeparateur;
use App\Filament\Bricks\Structure\BrickWizardPlaceholder;

class BrickRegistry
{
    protected static array $bricks = [];

    public static function register(): void
    {
        static::$bricks = [
            // Contenu
            'hero' => BrickHero::class,
            'hero-image' => BrickHeroImage::class,
            'texte' => BrickTexte::class,
            'cta' => BrickCTA::class,
            'cta-counter' => BrickCtaCounter::class,
            'cta-illustrated' => BrickCtaIllustrated::class,
            'cartes' => BrickCartes::class,
            'cartes-positioning' => BrickCartesPositioning::class,
            'cartes-articles' => BrickCartesArticles::class,
            'chiffres' => BrickChiffres::class,
            'faq' => BrickFAQ::class,
            'temoignages' => BrickTemoignages::class,
            'comparatif' => BrickComparatif::class,
            'formulaire' => BrickFormulaire::class,
            'methodologie' => BrickMethodologie::class,
            'timeline' => BrickTimeline::class,
            'fondateur' => BrickFondateur::class,
            'cas-usage' => BrickCasUsage::class,
            // Structure
            'separateur' => BrickSeparateur::class,
            'bandeau' => BrickBandeau::class,
            'logos' => BrickLogos::class,
            'wizard-placeholder' => BrickWizardPlaceholder::class,
        ];
    }

    public static function all(): array
    {
        if (empty(static::$bricks)) {
            static::register();
        }

        return array_map(fn ($class) => new $class(), static::$bricks);
    }

    public static function get(string $type): ?BaseBrick
    {
        if (empty(static::$bricks)) {
            static::register();
        }

        $class = static::$bricks[$type] ?? null;

        return $class ? new $class() : null;
    }

    public static function types(): array
    {
        if (empty(static::$bricks)) {
            static::register();
        }

        return array_keys(static::$bricks);
    }

    public static function byCategory(): array
    {
        $grouped = [];
        foreach (static::all() as $brick) {
            $grouped[$brick->category()][$brick->type()] = $brick;
        }

        return $grouped;
    }
}
