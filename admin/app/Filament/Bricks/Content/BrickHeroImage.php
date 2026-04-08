<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BrickHeroImage extends BaseBrick
{
    public function type(): string
    {
        return 'hero-image';
    }

    public function name(): string
    {
        return 'Hero Image';
    }

    public function icon(): string
    {
        return '🖼️';
    }

    public function description(): string
    {
        return 'Hero plein-largeur avec image de fond, badge, stats et double CTA (style accueil NeoGTB)';
    }

    public function category(): string
    {
        return 'Contenu';
    }

    public function defaultContent(): array
    {
        return [
            'badge' => '',
            'pre_titre' => '',
            'titre' => '',
            'description' => '',
            'image' => null,
            'image_alt' => '',
            'cta_texte' => '',
            'cta_lien' => '',
            'cta2_texte' => '',
            'cta2_lien' => '',
            'stats' => [],
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'hauteur' => 'min-520',
            'overlay' => 'gradient-left',
            'alignement' => 'right',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.badge')
                ->label('Badge')
                ->maxLength(80),

            TextInput::make('content.pre_titre')
                ->label('Pré-titre')
                ->maxLength(120),

            TextInput::make('content.titre')
                ->label('Titre principal')
                ->required()
                ->maxLength(160),

            Textarea::make('content.description')
                ->label('Description')
                ->rows(3)
                ->maxLength(500),

            FileUpload::make('content.image')
                ->disk('public')
                ->label('Image de fond')
                ->image()
                ->directory('bricks/hero-image')
                ->imageResizeMode('cover'),

            TextInput::make('content.image_alt')
                ->label('Texte alternatif de l\'image')
                ->maxLength(200),

            TextInput::make('content.cta_texte')
                ->label('CTA principal — Texte')
                ->maxLength(50),

            TextInput::make('content.cta_lien')
                ->label('CTA principal — Lien')
                ->placeholder('/contact'),

            TextInput::make('content.cta2_texte')
                ->label('CTA secondaire — Texte')
                ->maxLength(50),

            TextInput::make('content.cta2_lien')
                ->label('CTA secondaire — Lien')
                ->placeholder('/a-propos'),

            Repeater::make('content.stats')
                ->label('Statistiques')
                ->schema([
                    TextInput::make('valeur')
                        ->label('Valeur')
                        ->required()
                        ->maxLength(30),
                    TextInput::make('label')
                        ->label('Libellé')
                        ->required()
                        ->maxLength(80),
                ])
                ->columns(2)
                ->defaultItems(0)
                ->reorderable()
                ->collapsible(),

            Select::make('settings.hauteur')
                ->label('Hauteur')
                ->options([
                    'min-520' => 'Minimum 520px',
                    'min-640' => 'Minimum 640px',
                    'full' => 'Plein écran',
                ])
                ->default('min-520'),

            Select::make('settings.overlay')
                ->label('Overlay')
                ->options([
                    'gradient-left' => 'Dégradé gauche',
                    'gradient-right' => 'Dégradé droite',
                    'dark' => 'Sombre uniforme',
                    'none' => 'Aucun',
                ])
                ->default('gradient-left'),

            Select::make('settings.alignement')
                ->label('Alignement du contenu')
                ->options([
                    'left' => 'Gauche',
                    'center' => 'Centré',
                    'right' => 'Droite',
                ])
                ->default('right'),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre'] ?? 'Titre Hero Image';
        $description = $content['description'] ?? '';
        $descriptionCourt = mb_strlen($description) > 100
            ? mb_substr($description, 0, 100) . '…'
            : $description;

        return "<div class=\"font-bold\">{$titre}</div>"
            . "<div class=\"text-xs\">{$descriptionCourt}</div>";
    }
}
