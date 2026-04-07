<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BrickFondateur extends BaseBrick
{
    public function type(): string
    {
        return 'fondateur';
    }

    public function name(): string
    {
        return 'Fondateur / À propos';
    }

    public function icon(): string
    {
        return '👤';
    }

    public function description(): string
    {
        return 'Section présentation fondateur : photo, identité, bio et 3 cartes modèle économique';
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
            'texte' => '',
            'photo' => null,
            'photo_alt' => '',
            'nom' => '',
            'role' => '',
            'identite' => [],
            'modele_economique' => [],
            'cta_texte' => '',
            'cta_lien' => '',
        ];
    }

    public function defaultSettings(): array
    {
        return [];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.eyebrow')
                ->label('Eyebrow')
                ->maxLength(100),

            TextInput::make('content.nom')
                ->label('Nom')
                ->maxLength(120),

            TextInput::make('content.role')
                ->label('Rôle')
                ->maxLength(120),

            Textarea::make('content.titre')
                ->label('Titre (HTML <br/> accepté)')
                ->rows(2),

            Textarea::make('content.texte')
                ->label('Texte')
                ->rows(5),

            FileUpload::make('content.photo')
                ->label('Photo')
                ->image()
                ->directory('bricks/fondateur'),

            TextInput::make('content.photo_alt')
                ->label('Texte alternatif de la photo')
                ->maxLength(200),

            Repeater::make('content.identite')
                ->label('Identité (points bio)')
                ->simple(
                    TextInput::make('texte')
                        ->label('Texte')
                        ->required()
                ),

            Repeater::make('content.modele_economique')
                ->label('Modèle économique (3 cartes)')
                ->schema([
                    TextInput::make('titre')
                        ->label('Titre')
                        ->required()
                        ->maxLength(120),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(3),
                ]),

            TextInput::make('content.cta_texte')
                ->label('Texte du bouton CTA')
                ->maxLength(50),

            TextInput::make('content.cta_lien')
                ->label('Lien du bouton')
                ->placeholder('/contact'),
        ];
    }

    public function preview(array $content): string
    {
        return '<div class="font-bold">'.($content['nom'] ?? 'Fondateur').'</div>';
    }
}
