<?php

namespace App\Filament\Resources\ChatbotConversationResource\Pages;

use App\Filament\Resources\ChatbotConversationResource;
use App\Models\ChatbotConversation;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListChatbotConversations extends ListRecords
{
    protected static string $resource = ChatbotConversationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Exporter CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $convs = ChatbotConversation::orderBy('created_at', 'desc')->limit(2000)->get();
                    $csv = "ID;Lead;Email;Nom;Messages;Tokens IN;Tokens OUT;Coût €;Page origine;Date\n";
                    foreach ($convs as $c) {
                        $csv .= sprintf(
                            "%d;%s;\"%s\";\"%s\";%d;%d;%d;%.6f;\"%s\";\"%s\"\n",
                            $c->id,
                            $c->is_lead ? 'oui' : 'non',
                            $c->lead_email ?? '',
                            $c->lead_name ?? '',
                            $c->messages_count,
                            $c->total_tokens_in,
                            $c->total_tokens_out,
                            $c->total_cost_eur,
                            $c->referrer_url ?? '',
                            $c->created_at->format('d/m/Y H:i')
                        );
                    }
                    $path = storage_path('app/exports/chatbot-conversations-'.now()->format('Y-m-d').'.csv');
                    if (! is_dir(dirname($path))) {
                        mkdir(dirname($path), 0755, true);
                    }
                    file_put_contents($path, "\xEF\xBB\xBF".$csv);

                    return response()->download($path)->deleteFileAfterSend();
                }),

            Action::make('purge_old')
                ->label('Purger > 30j')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Purger les conversations anciennes ?')
                ->modalDescription('Supprime toutes les conversations dont la dernière activité date de plus de 30 jours.')
                ->action(function () {
                    $deleted = ChatbotConversation::where('last_activity_at', '<', now()->subDays(30))->delete();
                    Notification::make()
                        ->title("$deleted conversations purgées")
                        ->success()
                        ->send();
                }),
        ];
    }
}
