<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BrickCartes extends BaseBrick
{
    public function type(): string
    {
        return 'cartes';
    }

    public function name(): string
    {
        return 'Cartes';
    }

    public function icon(): string
    {
        return '🃏';
    }

    public function description(): string
    {
        return 'Grille de cartes avec icône, titre et description';
    }

    public function category(): string
    {
        return 'Contenu';
    }

    public function defaultContent(): array
    {
        return [
            'titre_section' => '',
            'cartes' => [],
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'colonnes' => 3,
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre_section')
                ->label('Titre de la section')
                ->maxLength(120),

            Repeater::make('content.cartes')
                ->label('Cartes')
                ->schema([
                    TextInput::make('icone')
                        ->label('Icône (emoji ou Heroicon)')
                        ->maxLength(50),

                    TextInput::make('titre')
                        ->label('Titre')
                        ->required()
                        ->maxLength(80),

                    Textarea::make('description')
                        ->label('Description')
                        ->rows(2)
                        ->maxLength(300),

                    TextInput::make('lien')
                        ->label('Lien (optionnel)')
                        ->placeholder('/page'),
                ])
                ->columns(2)
                ->minItems(1)
                ->maxItems(12)
                ->defaultItems(3)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['titre'] ?? 'Carte'),

            Select::make('settings.colonnes')
                ->label('Nombre de colonnes')
                ->options([
                    2 => '2 colonnes',
                    3 => '3 colonnes',
                    4 => '4 colonnes',
                ])
                ->default(3),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre_section'] ?? '';
        $nb = count($content['cartes'] ?? []);

        return ($titre ? "<div class=\"font-semibold\">{$titre}</div>" : '')
            . "<div class=\"text-sm text-gray-500\">{$nb} carte(s)</div>";
    }
}
