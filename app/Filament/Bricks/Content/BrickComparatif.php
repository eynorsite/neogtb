<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class BrickComparatif extends BaseBrick
{
    public function type(): string { return 'comparatif'; }
    public function name(): string { return 'Comparatif'; }
    public function icon(): string { return '⚖️'; }
    public function description(): string { return 'Tableau comparatif côte à côte'; }
    public function category(): string { return 'Contenu'; }

    public function defaultContent(): array
    {
        return [
            'titre' => '',
            'sous_titre' => '',
            'colonne_gauche_titre' => 'Avant',
            'colonne_droite_titre' => 'Après',
            'lignes_gauche' => [],
            'lignes_droite' => [],
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre')->label('Titre')->maxLength(120),
            TextInput::make('content.sous_titre')->label('Sous-titre')->maxLength(200),
            TextInput::make('content.colonne_gauche_titre')->label('Titre colonne gauche'),
            TextInput::make('content.colonne_droite_titre')->label('Titre colonne droite'),
            Repeater::make('content.lignes_gauche')->label('Points colonne gauche')
                ->schema([TextInput::make('texte')->label('Point')->required()])
                ->defaultItems(3)->collapsible()->itemLabel(fn (array $state) => $state['texte'] ?? 'Point'),
            Repeater::make('content.lignes_droite')->label('Points colonne droite')
                ->schema([TextInput::make('texte')->label('Point')->required()])
                ->defaultItems(3)->collapsible()->itemLabel(fn (array $state) => $state['texte'] ?? 'Point'),
        ];
    }

    public function preview(array $content): string
    {
        return '<div class="font-semibold">' . ($content['titre'] ?? 'Comparatif') . '</div>';
    }
}
