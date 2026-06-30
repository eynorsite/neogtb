<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\GdprRequestResource;
use App\Filament\Resources\PostResource;
use App\Models\ContactMessage;
use App\Models\GdprRequest;
use App\Models\Post;
use App\Models\SitePage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        // ⚡ Bolt: Cache dashboard stats for 60 seconds to prevent DB hammering on frequent dashboard loads
        $unread = Cache::remember('stats_unread_messages', 60, function () {
            return ContactMessage::where('status', 'new')->count();
        });

        $pendingGdpr = Cache::remember('stats_pending_gdpr', 60, function () {
            return GdprRequest::where('status', 'pending')->count();
        });

        $overdueGdpr = Cache::remember('stats_overdue_gdpr', 60, function () {
            return GdprRequest::where('status', 'pending')
                ->where('created_at', '<', now()->subDays(30))
                ->count();
        });

        $publishedPosts = Cache::remember('stats_published_posts', 60, function () {
            return Post::where('status', 'published')->count();
        });

        $activePages = Cache::remember('stats_active_pages', 60, function () {
            return SitePage::where('is_published', true)->count();
        });

        return [
            Stat::make('Messages non lus', $unread)
                ->description('Nouveaux messages de contact')
                ->icon('heroicon-o-envelope')
                ->color($unread > 0 ? 'danger' : 'success')
                ->url(ContactMessageResource::getUrl()),

            Stat::make('Demandes RGPD', $pendingGdpr)
                ->description($overdueGdpr > 0 ? "{$overdueGdpr} en retard (> 30j)" : 'Aucun retard')
                ->icon('heroicon-o-shield-check')
                ->color($overdueGdpr > 0 ? 'danger' : ($pendingGdpr > 0 ? 'warning' : 'success'))
                ->url(GdprRequestResource::getUrl()),

            Stat::make('Articles publiés', $publishedPosts)
                ->description('Articles sur le blog')
                ->icon('heroicon-o-newspaper')
                ->color('success')
                ->url(PostResource::getUrl()),

            Stat::make('Pages actives', $activePages)
                ->description('Pages du site')
                ->icon('heroicon-o-document-text')
                ->color('primary'),
        ];
    }
}
