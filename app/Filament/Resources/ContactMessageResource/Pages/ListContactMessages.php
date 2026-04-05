<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Resources\Pages\ListRecords;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export')
                ->label('Exporter CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $messages = ContactMessage::orderBy('created_at', 'desc')->get();
                    $csv = "Nom;Email;Sujet;Statut;Date\n";
                    foreach ($messages as $m) {
                        $csv .= "\"{$m->name}\";\"{$m->email}\";\"{$m->subject}\";\"{$m->status}\";\"{$m->created_at->format('d/m/Y H:i')}\"\n";
                    }
                    $path = storage_path('app/exports/messages-' . now()->format('Y-m-d') . '.csv');
                    if (!is_dir(dirname($path))) mkdir(dirname($path), 0755, true);
                    file_put_contents($path, "\xEF\xBB\xBF" . $csv);
                    return response()->download($path)->deleteFileAfterSend();
                }),
        ];
    }
}
