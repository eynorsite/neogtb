<?php

namespace App\Filament\Bricks\Structure;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class BrickLogos extends BaseBrick
{
    public function type(): string { return 'logos'; }
    public function name(): string { return 'Logos / Partenaires'; }
    public function icon(): string { return '🏷️'; }
    public function description(): string { return 'Carousel de logos partenaires/technologies'; }
    public function category(): string { return 'Structure'; }

    public function defaultContent(): array
    {
        return ['titre' => '', 'sous_titre' => '', 'logos' => []];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre')->label('Titre')->maxLength(120),
            TextInput::make('content.sous_titre')->label('Sous-titre')->maxLength(200),
            Repeater::make('content.logos')->label('Logos')
                ->schema([
                    TextInput::make('nom')->label('Nom')->required(),
                    TextInput::make('image')->label('Chemin image (/images/...)'),
                    TextInput::make('lien')->label('Lien (optionnel)'),
                ])
                ->defaultItems(4)->collapsible()
                ->itemLabel(fn (array $state) => $state['nom'] ?? 'Logo'),
        ];
    }

    public function preview(array $content): string
    {
        $nb = count($content['logos'] ?? []);
        return '<div class="font-semibold">' . ($content['titre'] ?? 'Logos') . '</div><div class="text-sm text-gray-500">' . $nb . ' logo(s)</div>';
    }
}
