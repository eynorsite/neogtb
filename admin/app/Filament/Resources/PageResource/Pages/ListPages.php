<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('Créer')];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\PageResource\Widgets\PagesGrid::class,
        ];
    }
}
