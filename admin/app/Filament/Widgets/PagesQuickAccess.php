<?php

namespace App\Filament\Widgets;

use App\Models\SitePage;
use Filament\Widgets\Widget;

class PagesQuickAccess extends Widget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.pages-quick-access';

    public function getPages(): \Illuminate\Support\Collection
    {
        return SitePage::where('is_published', true)
            ->orderBy('order')
            ->withCount('bricks')
            ->get();
    }
}
