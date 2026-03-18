<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Voir sur le site')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => '/' . $this->record->slug)
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
