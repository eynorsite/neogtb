<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\GdprRequest;
use App\Models\Post;
use App\Models\SitePage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $unread = ContactMessage::where('status', 'new')->count();
        $pendingGdpr = GdprRequest::where('status', 'pending')->count();
        $overdueGdpr = GdprRequest::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(30))
            ->count();

        return [
            Stat::make('Messages non lus', $unread)
                ->description('Nouveaux messages de contact')
                ->icon('heroicon-o-envelope')
                ->color($unread > 0 ? 'danger' : 'success')
                ->url(\App\Filament\Resources\ContactMessageResource::getUrl()),

            Stat::make('Demandes RGPD', $pendingGdpr)
                ->description($overdueGdpr > 0 ? "{$overdueGdpr} en retard (> 30j)" : 'Aucun retard')
                ->icon('heroicon-o-shield-check')
                ->color($overdueGdpr > 0 ? 'danger' : ($pendingGdpr > 0 ? 'warning' : 'success'))
                ->url(\App\Filament\Resources\GdprRequestResource::getUrl()),

            Stat::make('Articles publiés', Post::where('status', 'published')->count())
                ->description('Articles sur le blog')
                ->icon('heroicon-o-newspaper')
                ->color('success')
                ->url(\App\Filament\Resources\PostResource::getUrl()),

            Stat::make('Pages actives', SitePage::where('is_published', true)->count())
                ->description('Pages du site')
                ->icon('heroicon-o-document-text')
                ->color('primary'),
        ];
    }
}
