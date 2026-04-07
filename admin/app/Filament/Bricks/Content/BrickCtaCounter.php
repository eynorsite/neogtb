<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class BrickCtaCounter extends BaseBrick
{
    public function type(): string
    {
        return 'cta-counter';
    }

    public function name(): string
    {
        return 'CTA + Compteurs';
    }

    public function icon(): string
    {
        return '🔢';
    }

    public function description(): string
    {
        return 'CTA "honnête" avec compteurs d\'usage en haut et bouton double';
    }

    public function category(): string
    {
        return 'Contenu';
    }

    public function defaultContent(): array
    {
        return [
            'eyebrow' => '',
            'compteurs' => [],
            'titre' => '',
            'sous_titre' => '',
            'note' => '',
            'bouton_texte' => '',
            'bouton_lien' => '',
            'bouton2_texte' => '',
            'bouton2_lien' => '',
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'style' => 'honest-cta',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.eyebrow')
                ->label('Eyebrow')
                ->maxLength(100),

            Repeater::make('content.compteurs')
                ->label('Compteurs')
                ->schema([
                    TextInput::make('valeur')
                        ->label('Valeur')
                        ->required()
                        ->maxLength(20),
                    TextInput::make('label')
                        ->label('Label')
                        ->required()
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
                ->columns(3)
                ->defaultItems(0),

            TextInput::make('content.titre')
                ->label('Titre')
                ->required()
                ->maxLength(150),

            Textarea::make('content.sous_titre')
                ->label('Sous-titre')
                ->rows(2)
                ->maxLength(300),

            TextInput::make('content.note')
                ->label('Note')
                ->maxLength(200),

            TextInput::make('content.bouton_texte')
                ->label('Texte bouton principal')
                ->maxLength(50),

            TextInput::make('content.bouton_lien')
                ->label('Lien bouton principal')
                ->placeholder('/contact'),

            TextInput::make('content.bouton2_texte')
                ->label('Texte bouton secondaire')
                ->maxLength(50),

            TextInput::make('content.bouton2_lien')
                ->label('Lien bouton secondaire')
                ->placeholder('/en-savoir-plus'),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre'] ?? 'CTA + Compteurs';
        $bouton = $content['bouton_texte'] ?? 'Bouton';

        return "<div class=\"font-semibold\">{$titre}</div>"
            . "<div class=\"text-xs text-primary-600\">[{$bouton}]</div>";
    }
}
