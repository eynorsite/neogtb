<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BrickHero extends BaseBrick
{
    public function type(): string
    {
        return 'hero';
    }

    public function name(): string
    {
        return 'Hero';
    }

    public function icon(): string
    {
        return '🏔️';
    }

    public function description(): string
    {
        return 'Bannière principale avec titre, sous-titre et bouton CTA';
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
            'description' => '',
            'cta_texte' => '',
            'cta_lien' => '',
            'image' => null,
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'hauteur' => 'full',
            'overlay' => 40,
            'alignement' => 'center',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre')
                ->label('Titre principal')
                ->required()
                ->maxLength(120),

            TextInput::make('content.sous_titre')
                ->label('Sous-titre')
                ->maxLength(200),

            Textarea::make('content.description')
                ->label('Description')
                ->rows(3)
                ->maxLength(500),

            TextInput::make('content.cta_texte')
                ->label('Texte du bouton CTA')
                ->maxLength(50),

            TextInput::make('content.cta_lien')
                ->label('Lien du bouton')
                ->placeholder('/contact'),

            FileUpload::make('content.image')
                ->label('Image de fond')
                ->image()
                ->directory('bricks/hero')
                ->imageResizeMode('cover'),

            Select::make('settings.hauteur')
                ->label('Hauteur')
                ->options([
                    'full' => 'Plein écran (100vh)',
                    'medium' => 'Moyen (60vh)',
                    'compact' => 'Compact (40vh)',
                ])
                ->default('full'),

            TextInput::make('settings.overlay')
                ->label('Overlay sombre (%)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->default(40)
                ->suffix('%'),

            Select::make('settings.alignement')
                ->label('Alignement du texte')
                ->options([
                    'left' => 'Gauche',
                    'center' => 'Centré',
                    'right' => 'Droite',
                ])
                ->default('center'),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre'] ?? 'Titre Hero';
        $sousTitre = $content['sous_titre'] ?? '';

        return "<div class=\"font-bold text-base\">{$titre}</div>"
            . ($sousTitre ? "<div class=\"text-sm text-gray-500\">{$sousTitre}</div>" : '');
    }
}
