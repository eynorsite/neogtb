<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BrickTimeline extends BaseBrick
{
    public function type(): string
    {
        return 'timeline';
    }

    public function name(): string
    {
        return 'Timeline réglementaire';
    }

    public function icon(): string
    {
        return '📅';
    }

    public function description(): string
    {
        return 'Chronologie verticale de jalons réglementaires (BACS, décret tertiaire) avec dot past/present/futur';
    }

    public function category(): string
    {
        return 'Contenu';
    }

    public function defaultContent(): array
    {
        return [
            'eyebrow' => '',
            'eyebrow_color' => 'accent',
            'titre' => '',
            'points' => [],
            'legende' => [],
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'fond' => 'white-bordered',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.eyebrow')
                ->label('Eyebrow')
                ->maxLength(80),

            Select::make('content.eyebrow_color')
                ->label('Couleur eyebrow')
                ->options([
                    'accent' => 'Accent',
                    'energy' => 'Energy',
                ])
                ->default('accent'),

            TextInput::make('content.titre')
                ->label('Titre')
                ->required()
                ->maxLength(150),

            Repeater::make('content.points')
                ->label('Points de la timeline')
                ->schema([
                    TextInput::make('annee')
                        ->label('Année')
                        ->maxLength(20),
                    TextInput::make('label')
                        ->label('Label')
                        ->maxLength(150),
                    Textarea::make('detail')
                        ->label('Détail')
                        ->rows(2)
                        ->maxLength(300),
                    Select::make('etat')
                        ->label('État')
                        ->options([
                            'past' => 'Passé',
                            'present' => 'Présent',
                            'futur' => 'Futur',
                        ]),
                ])
                ->columns(1),

            Repeater::make('content.legende')
                ->label('Légende')
                ->schema([
                    Select::make('couleur')
                        ->label('Couleur')
                        ->options([
                            'accent' => 'Accent',
                            'energy' => 'Energy',
                            'dark' => 'Sombre',
                        ]),
                    TextInput::make('texte')
                        ->label('Texte')
                        ->maxLength(120),
                ])
                ->columns(2),

            Select::make('settings.fond')
                ->label('Fond')
                ->options([
                    'none' => 'Aucun',
                    'white-bordered' => 'Blanc bordé',
                    'dark-50' => 'Sombre 50',
                ])
                ->default('white-bordered'),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre'] ?? 'Timeline';
        $count = is_array($content['points'] ?? null) ? count($content['points']) : 0;

        return "<div class=\"font-bold text-base\">{$titre}</div>"
            . "<div class=\"text-sm text-gray-500\">{$count} jalon(s)</div>";
    }
}
