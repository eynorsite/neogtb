<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BrickCasUsage extends BaseBrick
{
    public function type(): string
    {
        return 'cas-usage';
    }

    public function name(): string
    {
        return 'Cas d\'usage';
    }

    public function icon(): string
    {
        return '💼';
    }

    public function description(): string
    {
        return 'Cards de cas d\'usage avec tag, contexte, approche, gauge ISO 52120-1 et métriques chiffrées';
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
            'cas' => [],
            'cta_texte' => '',
            'cta_lien' => '',
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'colonnes' => 2,
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.eyebrow')
                ->label('Eyebrow')
                ->maxLength(100),

            TextInput::make('content.titre')
                ->label('Titre de la section')
                ->maxLength(200),

            Repeater::make('content.cas')
                ->label('Cas d\'usage')
                ->schema([
                    TextInput::make('tag')
                        ->label('Tag')
                        ->maxLength(50),

                    Select::make('tag_variant')
                        ->label('Variante du tag')
                        ->options([
                            'reglementation' => 'Réglementation',
                            'technique' => 'Technique',
                            'protocoles' => 'Protocoles',
                            'gtb' => 'GTB',
                        ])
                        ->default('gtb'),

                    TextInput::make('meta')
                        ->label('Meta')
                        ->placeholder('Tertiaire · 12 000 m²')
                        ->maxLength(150),

                    TextInput::make('titre')
                        ->label('Titre du cas')
                        ->maxLength(200),

                    Textarea::make('contexte')
                        ->label('Contexte')
                        ->rows(3),

                    Textarea::make('approche')
                        ->label('Approche')
                        ->rows(3),

                    Select::make('gauge.progress_from')
                        ->label('Gauge — Départ')
                        ->options([
                            'A' => 'A',
                            'B' => 'B',
                            'C' => 'C',
                            'D' => 'D',
                            'none' => 'Aucun',
                        ])
                        ->default('none'),

                    Select::make('gauge.active')
                        ->label('Gauge — Classe active')
                        ->options([
                            'A' => 'A',
                            'B' => 'B',
                            'C' => 'C',
                            'D' => 'D',
                        ])
                        ->default('A'),

                    TextInput::make('gauge.label')
                        ->label('Gauge — Label')
                        ->maxLength(100),

                    Repeater::make('metriques')
                        ->label('Métriques')
                        ->schema([
                            TextInput::make('valeur')
                                ->label('Valeur')
                                ->maxLength(50),

                            TextInput::make('label')
                                ->label('Label')
                                ->maxLength(100),

                            Select::make('couleur')
                                ->label('Couleur')
                                ->options([
                                    'dark' => 'Dark',
                                    'accent' => 'Accent',
                                    'energy' => 'Energy',
                                ])
                                ->default('dark'),
                        ])
                        ->defaultItems(0)
                        ->collapsible(),
                ])
                ->defaultItems(0)
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['titre'] ?? null),

            TextInput::make('content.cta_texte')
                ->label('Texte du bouton CTA')
                ->maxLength(50),

            TextInput::make('content.cta_lien')
                ->label('Lien du bouton')
                ->placeholder('/contact'),

            Select::make('settings.colonnes')
                ->label('Nombre de colonnes')
                ->options([
                    1 => '1 colonne',
                    2 => '2 colonnes',
                ])
                ->default(2),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre'] ?? 'Cas d\'usage';
        $nb = is_array($content['cas'] ?? null) ? count($content['cas']) : 0;

        return "<div class=\"font-bold text-base\">{$titre}</div>"
            . "<div class=\"text-sm text-gray-500\">{$nb} cas</div>";
    }
}
