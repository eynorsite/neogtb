<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BrickCtaIllustrated extends BaseBrick
{
    public function type(): string
    {
        return 'cta-illustrated';
    }

    public function name(): string
    {
        return 'CTA Illustré';
    }

    public function icon(): string
    {
        return '🎨';
    }

    public function description(): string
    {
        return 'CTA final avec image de fond illustrative et gradient';
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
            'image_fond' => null,
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'style' => 'illustrated',
            'fond' => '#F0F2F5',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre')
                ->label('Titre')
                ->required()
                ->maxLength(150),

            Textarea::make('content.sous_titre')
                ->label('Sous-titre')
                ->rows(2)
                ->maxLength(300),

            TextInput::make('content.bouton_texte')
                ->label('Texte du bouton')
                ->required()
                ->maxLength(50),

            TextInput::make('content.bouton_lien')
                ->label('Lien du bouton')
                ->required()
                ->placeholder('/contact'),

            FileUpload::make('content.image_fond')
                ->disk('public')
                ->label('Image de fond')
                ->image()
                ->directory('bricks/cta'),

            TextInput::make('settings.fond')
                ->label('Couleur de fond')
                ->placeholder('#F0F2F5')
                ->default('#F0F2F5'),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre'] ?? 'CTA Illustré';
        $bouton = $content['bouton_texte'] ?? 'Bouton';

        return "<div class=\"font-semibold\">{$titre}</div>"
            . "<div class=\"text-xs text-primary-600\">[{$bouton}]</div>";
    }
}
