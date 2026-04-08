<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BrickTexte extends BaseBrick
{
    public function type(): string
    {
        return 'texte';
    }

    public function name(): string
    {
        return 'Texte';
    }

    public function icon(): string
    {
        return '📝';
    }

    public function description(): string
    {
        return 'Bloc de texte riche avec titre et image optionnelle';
    }

    public function category(): string
    {
        return 'Contenu';
    }

    public function defaultContent(): array
    {
        return [
            'titre' => '',
            'contenu' => '',
            'image' => null,
        ];
    }

    public function defaultSettings(): array
    {
        return [
            'position_image' => 'none',
            'couleur_fond' => '#ffffff',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre')
                ->label('Titre de la section')
                ->maxLength(120),

            RichEditor::make('content.contenu')
                ->label('Contenu')
                ->required()
                ->columnSpanFull(),

            FileUpload::make('content.image')
                ->disk('public')
                ->label('Image')
                ->image()
                ->directory('bricks/texte'),

            Select::make('settings.position_image')
                ->label('Position de l\'image')
                ->options([
                    'none' => 'Pas d\'image',
                    'left' => 'Gauche',
                    'right' => 'Droite',
                    'top' => 'Au-dessus',
                ])
                ->default('none'),

            TextInput::make('settings.couleur_fond')
                ->label('Couleur de fond')
                ->type('color')
                ->default('#ffffff'),
        ];
    }

    public function preview(array $content): string
    {
        $titre = $content['titre'] ?? '';
        $contenu = strip_tags($content['contenu'] ?? '');
        $extrait = mb_substr($contenu, 0, 80);

        return ($titre ? "<div class=\"font-semibold\">{$titre}</div>" : '')
            . "<div class=\"text-sm text-gray-500\">{$extrait}...</div>";
    }
}
