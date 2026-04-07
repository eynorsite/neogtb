<?php

namespace App\Filament\Resources\CeeLeadResource\Pages;

use App\Filament\Resources\CeeLeadResource;
use App\Models\CeeLead;
use Filament\Resources\Pages\ListRecords;

class ListCeeLeads extends ListRecords
{
    protected static string $resource = CeeLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export')
                ->label('Exporter CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $leads = CeeLead::orderBy('created_at', 'desc')->get();
                    $csv = "Email;Secteur;Surface;Zone;TH-116 MWh;Valeur €;Statut;Date\n";
                    foreach ($leads as $l) {
                        $csv .= "\"{$l->email}\";\"{$l->sector}\";\"{$l->surface}\";\"{$l->climate_zone}\";\"{$l->th116_mwh}\";\"{$l->th116_value}\";\"{$l->status}\";\"{$l->created_at->format('d/m/Y H:i')}\"\n";
                    }
                    $path = storage_path('app/exports/cee-leads-' . now()->format('Y-m-d') . '.csv');
                    if (!is_dir(dirname($path))) mkdir(dirname($path), 0755, true);
                    file_put_contents($path, "\xEF\xBB\xBF" . $csv);
                    return response()->download($path)->deleteFileAfterSend();
                }),
        ];
    }
}
