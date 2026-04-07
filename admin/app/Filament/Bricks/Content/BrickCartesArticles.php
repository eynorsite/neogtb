<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BrickCartesArticles extends BaseBrick
{
    public function type(): string
    {
        return 'cartes-articles';
    }

    public function name(): string
    {
        return 'Cartes Articles';
    }

    public function icon(): string
    {
        return '📰';
    }

    public function description(): string
    {
        return 'Liste de cartes d\'articles blog avec tag, titre et durée de lecture';
    }

    public function category(): string
    {
        return 'Contenu';
    }

    public function defaultContent(): array
    {
        return [
            'eyebrow' => '',
            'titre_section' => '',
            'cta_haut_texte' => '',
            'cta_haut_lien' => '',
            'cartes' => [],
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'colonnes' => 3,
            'fond' => 'dark-50',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.eyebrow')
                ->label('Eyebrow')
                ->maxLength(120),

            TextInput::make('content.titre_section')
                ->label('Titre de la section')
                ->maxLength(200),

            TextInput::make('content.cta_haut_texte')
                ->label('Texte du CTA (haut)')
                ->maxLength(80),

            TextInput::make('content.cta_haut_lien')
                ->label('Lien du CTA (haut)')
                ->placeholder('/blog'),

            Repeater::make('content.cartes')
                ->label('Articles')
                ->schema([
                    TextInput::make('tag')
                        ->label('Tag')
                        ->maxLength(50),

                    Select::make('tag_variant')
                        ->label('Variante de tag')
                        ->options([
                            'reglementation' => 'Réglementation',
                            'technique' => 'Technique',
                            'protocoles' => 'Protocoles',
                            'gtb' => 'GTB',
                        ]),

                    TextInput::make('titre')
                        ->label('Titre')
                        ->required()
                        ->maxLength(200),

                    TextInput::make('duree')
                        ->label('Durée de lecture')
                        ->placeholder('5 min'),

                    TextInput::make('lien')
                        ->label('Lien')
                        ->placeholder('/blog/slug'),
                ])
                ->columns(2)
                ->minItems(1)
                ->maxItems(12)
                ->defaultItems(3)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['titre'] ?? 'Article'),

            Select::make('settings.colonnes')
                ->label('Nombre de colonnes')
                ->options([
                    1 => '1 colonne',
                    2 => '2 colonnes',
                    3 => '3 colonnes',
                    4 => '4 colonnes',
                ])
                ->default(3),

            Select::make('settings.fond')
                ->label('Fond de section')
                ->options([
                    'none' => 'Aucun',
                    'dark-50' => 'Dark 50',
                ])
                ->default('dark-50'),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre_section'] ?? '';
        $nb = count($content['cartes'] ?? []);

        return ($titre ? "<div class=\"font-semibold\">{$titre}</div>" : '')
            . "<div class=\"text-sm text-gray-500\">{$nb} article(s)</div>";
    }
}
