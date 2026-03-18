<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class BrickTemoignages extends BaseBrick
{
    public function type(): string { return 'temoignages'; }
    public function name(): string { return 'Témoignages'; }
    public function icon(): string { return '💬'; }
    public function description(): string { return 'Avis et témoignages clients'; }
    public function category(): string { return 'Contenu'; }

    public function defaultContent(): array
    {
        return ['titre' => 'Ce que disent nos clients', 'avis' => []];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre')->label('Titre de la section')->maxLength(120),
            Repeater::make('content.avis')
                ->label('Témoignages')
                ->schema([
                    TextInput::make('nom')->label('Nom')->required(),
                    TextInput::make('poste')->label('Poste / Entreprise'),
                    Textarea::make('texte')->label('Témoignage')->required()->rows(3),
                    TextInput::make('note')->label('Note (1-5)')->numeric()->minValue(1)->maxValue(5),
                ])
                ->minItems(1)->maxItems(12)->defaultItems(3)->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['nom'] ?? 'Avis'),
        ];
    }

    public function preview(array $content): string
    {
        $nb = count($content['avis'] ?? []);
        return "<div class=\"font-semibold\">" . ($content['titre'] ?? 'Témoignages') . "</div>"
            . "<div class=\"text-sm text-gray-500\">{$nb} avis</div>";
    }
}
