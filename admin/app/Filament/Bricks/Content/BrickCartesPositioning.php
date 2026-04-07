<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BrickCartesPositioning extends BaseBrick
{
    public function type(): string
    {
        return 'cartes-positioning';
    }

    public function name(): string
    {
        return 'Cartes Positioning';
    }

    public function icon(): string
    {
        return '🎯';
    }

    public function description(): string
    {
        return 'Trois cartes "outils" avec icône, description, preview optionnelle (gauge ou estimation CEE) et CTA (style accueil NeoGTB)';
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
            'sous_titre' => '',
            'cartes' => [],
            'cta_inline_texte' => '',
            'cta_inline_lien_texte' => '',
            'cta_inline_lien' => '',
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
            TextInput::make('content.eyebrow')
                ->label('Eyebrow')
                ->maxLength(120),

            TextInput::make('content.titre_section')
                ->label('Titre de la section')
                ->maxLength(200),

            Textarea::make('content.sous_titre')
                ->label('Sous-titre')
                ->rows(2)
                ->maxLength(500),

            Repeater::make('content.cartes')
                ->label('Cartes')
                ->schema([
                    TextInput::make('icone')
                        ->label('Icône (emoji ou Heroicon)')
                        ->maxLength(50),

                    TextInput::make('titre')
                        ->label('Titre')
                        ->required()
                        ->maxLength(120),

                    Textarea::make('description')
                        ->label('Description')
                        ->rows(3)
                        ->maxLength(500),

                    TextInput::make('lien')
                        ->label('Lien')
                        ->placeholder('/page'),

                    TextInput::make('cta_texte')
                        ->label('Texte du CTA')
                        ->maxLength(80),

                    Select::make('preview')
                        ->label('Preview')
                        ->options([
                            '' => 'Aucune',
                            'gauge-en15232' => 'Gauge ISO 52120-1',
                            'estimation-cee' => 'Estimation CEE',
                        ])
                        ->default(''),
                ])
                ->columns(2)
                ->minItems(1)
                ->maxItems(6)
                ->defaultItems(3)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['titre'] ?? 'Carte'),

            TextInput::make('content.cta_inline_texte')
                ->label('Texte inline CTA')
                ->maxLength(200),

            TextInput::make('content.cta_inline_lien_texte')
                ->label('Texte du lien inline')
                ->maxLength(80),

            TextInput::make('content.cta_inline_lien')
                ->label('Lien inline')
                ->placeholder('/page'),

            Select::make('settings.colonnes')
                ->label('Nombre de colonnes')
                ->options([
                    1 => '1 colonne',
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
