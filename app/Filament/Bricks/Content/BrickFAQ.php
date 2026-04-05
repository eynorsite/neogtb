<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BrickFAQ extends BaseBrick
{
    public function type(): string { return 'faq'; }
    public function name(): string { return 'FAQ'; }
    public function icon(): string { return '❓'; }
    public function description(): string { return 'Questions/réponses en accordéon'; }
    public function category(): string { return 'Contenu'; }

    public function defaultContent(): array
    {
        return ['titre' => 'Questions fréquentes', 'questions' => []];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre')->label('Titre de la section')->maxLength(120),
            Repeater::make('content.questions')
                ->label('Questions')
                ->schema([
                    TextInput::make('question')->label('Question')->required(),
                    Textarea::make('reponse')->label('Réponse')->required()->rows(3),
                ])
                ->minItems(1)->maxItems(20)->defaultItems(3)->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['question'] ?? 'Question'),
        ];
    }

    public function preview(array $content): string
    {
        $nb = count($content['questions'] ?? []);
        return "<div class=\"font-semibold\">" . ($content['titre'] ?? 'FAQ') . "</div>"
            . "<div class=\"text-sm text-gray-500\">{$nb} question(s)</div>";
    }
}
