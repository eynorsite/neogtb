<?php

namespace App\Filament\Resources\CctpLeadResource\Pages;

use App\Filament\Resources\CctpLeadResource;
use App\Models\CctpLead;
use Filament\Resources\Pages\ListRecords;

class ListCctpLeads extends ListRecords
{
    protected static string $resource = CctpLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export')
                ->label('Exporter CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $leads = CctpLead::orderBy('created_at', 'desc')->get();
                    $csv = "Email;Organisation;Statut;Date\n";
                    foreach ($leads as $l) {
                        $csv .= "\"{$l->email}\";\"{$l->company}\";\"{$l->status}\";\"{$l->created_at->format('d/m/Y H:i')}\"\n";
                    }
                    $path = storage_path('app/exports/cctp-leads-' . now()->format('Y-m-d') . '.csv');
                    if (!is_dir(dirname($path))) mkdir(dirname($path), 0755, true);
                    file_put_contents($path, "\xEF\xBB\xBF" . $csv);
                    return response()->download($path)->deleteFileAfterSend();
                }),
        ];
    }
}
