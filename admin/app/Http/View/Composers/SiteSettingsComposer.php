<?php

namespace App\Http\View\Composers;

use App\Models\GeneralSetting;
use App\Services\SiteConfigService;
use Illuminate\View\View;

class SiteSettingsComposer
{
    public function __construct(
        protected SiteConfigService $configService,
    ) {}

    public function compose(View $view): void
    {
        $view->with('site', $this->configService);
        $view->with('settings', GeneralSetting::get());
    }
}
