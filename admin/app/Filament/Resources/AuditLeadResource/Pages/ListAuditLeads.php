<?php

namespace App\Filament\Resources\AuditLeadResource\Pages;

use App\Filament\Resources\AuditLeadResource;
use App\Models\AuditLead;
use Filament\Resources\Pages\ListRecords;

class ListAuditLeads extends ListRecords
{
    protected static string $resource = AuditLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export')
                ->label('Exporter CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $leads = AuditLead::orderBy('created_at', 'desc')->get();
                    $csv = "Email;Nom;Société;Score;Niveau;Type bâtiment;Surface;Économies €/an;Statut;Date\n";
                    foreach ($leads as $l) {
                        $csv .= "\"{$l->email}\";\"{$l->name}\";\"{$l->company}\";\"{$l->score}\";\"{$l->level_label}\";\"{$l->building_type}\";\"{$l->surface}\";\"{$l->savings_euro}\";\"{$l->status}\";\"{$l->created_at->format('d/m/Y H:i')}\"\n";
                    }
                    $path = storage_path('app/exports/audit-leads-' . now()->format('Y-m-d') . '.csv');
                    if (!is_dir(dirname($path))) mkdir(dirname($path), 0755, true);
                    file_put_contents($path, "\xEF\xBB\xBF" . $csv);
                    return response()->download($path)->deleteFileAfterSend();
                }),
        ];
    }
}
