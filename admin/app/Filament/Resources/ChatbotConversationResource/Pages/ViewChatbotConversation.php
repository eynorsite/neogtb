<?php

namespace App\Filament\Resources\ChatbotConversationResource\Pages;

use App\Filament\Resources\ChatbotConversationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewChatbotConversation extends ViewRecord
{
    protected static string $resource = ChatbotConversationResource::class;

    protected string $view = 'filament.resources.chatbot-conversation.view';

    protected function getHeaderActions(): array
    {
        return [EditAction::make()->label('Éditer le lead')];
    }
}
