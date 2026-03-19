<?php

namespace App\Filament\Resources\PageResource\Widgets;

use App\Models\SitePage;
use Filament\Widgets\Widget;

class PagesGrid extends Widget
{
    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.pages-grid';

    public function getPages(): \Illuminate\Support\Collection
    {
        return SitePage::orderBy('order')->withCount('bricks')->get();
    }
}
