<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class BrickChiffres extends BaseBrick
{
    public function type(): string
    {
        return 'chiffres';
    }

    public function name(): string
    {
        return 'Chiffres clés';
    }

    public function icon(): string
    {
        return '📊';
    }

    public function description(): string
    {
        return 'Statistiques et chiffres clés animés';
    }

    public function category(): string
    {
        return 'Contenu';
    }

    public function defaultContent(): array
    {
        return [
            'titre' => '',
            'sous_titre' => '',
            'stats' => [],
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'couleur_fond' => '#f8fafc',
            'animation' => true,
        ];
    }

    public function schema(): array
    {
        return [
            Repeater::make('content.stats')
                ->label('Statistiques')
                ->schema([
                    TextInput::make('icone')
                        ->label('Icône (emoji)')
                        ->maxLength(10),

                    TextInput::make('valeur')
                        ->label('Valeur')
                        ->required()
                        ->placeholder('1200'),

                    TextInput::make('suffixe')
                        ->label('Suffixe')
                        ->placeholder('+, %, m², etc.'),

                    TextInput::make('label')
                        ->label('Label')
                        ->required()
                        ->placeholder('Clients satisfaits'),
                ])
                ->columns(4)
                ->minItems(2)
                ->maxItems(6)
                ->defaultItems(3)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => ($state['valeur'] ?? '') . ' ' . ($state['label'] ?? 'Stat')),

            TextInput::make('settings.couleur_fond')
                ->label('Couleur de fond')
                ->type('color')
                ->default('#f8fafc'),

            Toggle::make('settings.animation')
                ->label('Animation au scroll')
                ->default(true),
        ];
    }

    public function preview(array $content): string
    {
        $stats = $content['stats'] ?? [];
        $nb = count($stats);

        if ($nb === 0) {
            return '<div class="text-sm text-gray-500">Aucune statistique</div>';
        }

        $items = array_map(
            fn ($s) => '<span class="font-bold">' . ($s['valeur'] ?? '') . ($s['suffixe'] ?? '') . '</span> ' . ($s['label'] ?? ''),
            array_slice($stats, 0, 3)
        );

        return '<div class="text-sm">' . implode(' · ', $items) . '</div>';
    }
}
