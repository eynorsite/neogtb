<?php

namespace App\Filament\Bricks\Content;

use App\Filament\Bricks\BaseBrick;
use Filament\Forms\Components\TextInput;

class BrickFormulaire extends BaseBrick
{
    public function type(): string { return 'formulaire'; }
    public function name(): string { return 'Formulaire'; }
    public function icon(): string { return '📝'; }
    public function description(): string { return 'Formulaire de contact intégré'; }
    public function category(): string { return 'Contenu'; }

    public function defaultContent(): array
    {
        return [
            'titre' => 'Envoyez-nous un message',
            'email_destination' => 'contact@neogtb.fr',
            'message_succes' => 'Merci ! Votre message a bien été envoyé.',
        ];
    }

    public function schema(): array
    {
        return [
            TextInput::make('content.titre')->label('Titre du formulaire'),
            TextInput::make('content.email_destination')->label('Email de destination')->email(),
            TextInput::make('content.message_succes')->label('Message de succès'),
        ];
    }

    public function preview(array $content): string
    {
        return '<div class="font-semibold">' . ($content['titre'] ?? 'Formulaire') . '</div>';
    }
}
