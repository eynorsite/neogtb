<?php

namespace App\Filament\Resources\ChatbotFaqResource\Pages;

use App\Filament\Resources\ChatbotFaqResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChatbotFaqs extends ListRecords
{
    protected static string $resource = ChatbotFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Nouvelle FAQ')];
    }
}
