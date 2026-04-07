<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class BrickMethodologie extends BaseBrick
{
    public function type(): string
    {
        return 'methodologie';
    }

    public function name(): string
    {
        return 'Méthodologie';
    }

    public function icon(): string
    {
        return '🧭';
    }

    public function description(): string
    {
        return 'Flow horizontal de 4 étapes avec icône, titre, description et étape active';
    }

    public function category(): string
    {
        return 'Contenu';
    }

    public function defaultContent(): array
    {
        return [
            'eyebrow' => '',
            'titre' => '',
            'sous_titre' => '',
            'cta_texte' => '',
            'cta_lien' => '',
            'etapes' => [],
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'fond' => 'dark-50',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.eyebrow')
                ->label('Eyebrow')
                ->maxLength(80),

            TextInput::make('content.titre')
                ->label('Titre')
                ->required()
                ->maxLength(150),

            TextInput::make('content.sous_titre')
                ->label('Sous-titre')
                ->maxLength(200),

            TextInput::make('content.cta_texte')
                ->label('Texte du bouton CTA')
                ->maxLength(50),

            TextInput::make('content.cta_lien')
                ->label('Lien du bouton')
                ->placeholder('/contact'),

            Repeater::make('content.etapes')
                ->label('Étapes')
                ->schema([
                    TextInput::make('numero')
                        ->label('Numéro')
                        ->numeric(),
                    Select::make('icone')
                        ->label('Icône')
                        ->options([
                            'search' => 'Loupe',
                            'bars' => 'Barres',
                            'check' => 'Coche',
                            'bolt' => 'Éclair',
                        ]),
                    TextInput::make('titre')
                        ->label('Titre')
                        ->maxLength(120),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(2)
                        ->maxLength(250),
                    Toggle::make('active')
                        ->label('Étape active'),
                ])
                ->defaultItems(4)
                ->columns(1),

            Select::make('settings.fond')
                ->label('Fond')
                ->options([
                    'none' => 'Aucun',
                    'dark-50' => 'Sombre 50',
                ])
                ->default('dark-50'),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre'] ?? 'Méthodologie';
        $count = is_array($content['etapes'] ?? null) ? count($content['etapes']) : 0;

        return "<div class=\"font-bold text-base\">{$titre}</div>"
            . "<div class=\"text-sm text-gray-500\">{$count} étape(s)</div>";
    }
}
