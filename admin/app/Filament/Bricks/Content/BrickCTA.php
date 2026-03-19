<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BrickCTA extends BaseBrick
{
    public function type(): string
    {
        return 'cta';
    }

    public function name(): string
    {
        return 'Appel à l\'action';
    }

    public function icon(): string
    {
        return '🎯';
    }

    public function description(): string
    {
        return 'Bandeau d\'appel à l\'action avec titre et bouton';
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
            'bouton_texte' => '',
            'bouton_lien' => '',
            'bouton2_texte' => '',
            'bouton2_lien' => '',
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'style' => 'primary',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre')
                ->label('Titre accroche')
                ->required()
                ->maxLength(120),

            TextInput::make('content.sous_titre')
                ->label('Sous-titre')
                ->maxLength(200),

            TextInput::make('content.bouton_texte')
                ->label('Texte du bouton')
                ->required()
                ->maxLength(50),

            TextInput::make('content.bouton_lien')
                ->label('Lien du bouton')
                ->required()
                ->placeholder('/contact'),

            Select::make('settings.style')
                ->label('Style')
                ->options([
                    'primary' => 'Couleur primaire',
                    'dark' => 'Fond sombre',
                    'light' => 'Fond clair',
                ])
                ->default('primary'),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre'] ?? 'Appel à l\'action';
        $bouton = $content['bouton_texte'] ?? 'Bouton';

        return "<div class=\"font-semibold\">{$titre}</div>"
            . "<div class=\"text-xs text-primary-600\">[{$bouton}]</div>";
    }
}
