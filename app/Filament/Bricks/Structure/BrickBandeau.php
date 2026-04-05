<?php

namespace App\Filament\Bricks\Structure;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\TextInput;

class BrickBandeau extends BaseBrick
{
    public function type(): string { return 'bandeau'; }
    public function name(): string { return 'Bandeau'; }
    public function icon(): string { return '📢'; }
    public function description(): string { return 'Bandeau pleine largeur (annonce, promo)'; }
    public function category(): string { return 'Structure'; }

    public function defaultContent(): array
    {
        return ['texte' => '', 'lien' => ''];
    }

    public function defaultSettings(): array
    {
        return ['couleur_fond' => '#0F6BAF', 'couleur_texte' => '#ffffff'];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.texte')->label('Texte du bandeau')->required()->maxLength(200),
            TextInput::make('content.lien')->label('Lien (optionnel)')->placeholder('/contact'),
            TextInput::make('settings.couleur_fond')->label('Couleur de fond')->type('color')->default('#0F6BAF'),
            TextInput::make('settings.couleur_texte')->label('Couleur du texte')->type('color')->default('#ffffff'),
        ];
    }

    public function preview(array $content): string
    {
        return '<div class="text-sm">' . ($content['texte'] ?? 'Bandeau') . '</div>';
    }
}
