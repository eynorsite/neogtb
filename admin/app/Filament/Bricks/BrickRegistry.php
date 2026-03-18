<?php

namespace App\Filament\Bricks;

use App\Filament\Bricks\Content\BrickHero;
use App\Filament\Bricks\Content\BrickTexte;
use App\Filament\Bricks\Content\BrickCTA;
use App\Filament\Bricks\Content\BrickCartes;
use App\Filament\Bricks\Content\BrickChiffres;

class BrickRegistry
{
    protected static array $bricks = [];

    public static function register(): void
    {
        static::$bricks = [
            'hero' => BrickHero::class,
            'texte' => BrickTexte::class,
            'cta' => BrickCTA::class,
            'cartes' => BrickCartes::class,
            'chiffres' => BrickChiffres::class,
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
