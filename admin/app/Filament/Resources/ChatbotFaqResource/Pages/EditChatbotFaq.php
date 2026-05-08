<?php

namespace App\Filament\Resources\ChatbotFaqResource\Pages;

use App\Filament\Resources\ChatbotFaqResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChatbotFaq extends EditRecord
{
    protected static string $resource = ChatbotFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
