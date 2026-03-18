<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\PageBrick;
use App\Models\Post;
use App\Models\SitePage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Messages non lus', ContactMessage::where('status', 'new')->count())
                ->description('Nouveaux messages de contact')
                ->icon('heroicon-o-envelope')
                ->color('danger'),

            Stat::make('Articles publiés', Post::where('status', 'published')->count())
                ->description('Articles sur le blog')
                ->icon('heroicon-o-newspaper')
                ->color('success'),

            Stat::make('Pages du site', SitePage::where('is_published', true)->count())
                ->description('Pages actives')
                ->icon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Bricks', PageBrick::count())
                ->description(PageBrick::where('is_visible', true)->count() . ' visibles')
                ->icon('heroicon-o-cube')
                ->color('warning'),
        ];
    }
}
