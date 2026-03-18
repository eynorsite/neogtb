<?php

namespace App\Filament\Bricks\Structure;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BrickSeparateur extends BaseBrick
{
    public function type(): string { return 'separateur'; }
    public function name(): string { return 'Séparateur'; }
    public function icon(): string { return '➖'; }
    public function description(): string { return 'Espace visuel entre sections'; }
    public function category(): string { return 'Structure'; }

    public function defaultContent(): array
    {
        return [];
    }

    public function defaultSettings(): array
    {
        return ['hauteur' => '40', 'style' => 'ligne'];
    }

    public function schema(): array
    {
        return [
            TextInput::make('settings.hauteur')
                ->label('Hauteur (px)')
                ->numeric()->default(40),
            Select::make('settings.style')
                ->label('Style')
                ->options([
                    'vide' => 'Espace vide',
                    'ligne' => 'Ligne fine',
                    'pointilles' => 'Pointillés',
                ])
                ->default('ligne'),
        ];
    }

    public function preview(array $content): string
    {
        return '<div class="text-xs text-gray-400">— séparateur —</div>';
    }
}
