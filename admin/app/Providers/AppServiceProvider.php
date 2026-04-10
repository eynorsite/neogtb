<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\ContactMessage;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\SitePage;
use App\Models\GeneralSetting;
use App\Models\PageBrick;
use App\Observers\AdminAuditObserver;
use App\Observers\SiteSettingObserver;
use App\Services\SiteConfigService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SiteConfigService::class);
    }

    public function boot(): void
    {
        // Force Carbon locale to French
        Carbon::setLocale('fr');

        // Audit observer on all admin-managed models
        $models = [
            Admin::class,
            SitePage::class,
            GeneralSetting::class,
            Post::class,
            PostCategory::class,
            ContactMessage::class,
            NavigationMenu::class,
            NavigationItem::class,
            \App\Models\GdprRequest::class,
            \App\Models\AuditLead::class,
            \App\Models\CeeLead::class,
            \App\Models\CookieConsent::class,
            \App\Models\NewsletterSubscriber::class,
        ];

        foreach ($models as $model) {
            $model::observe(AdminAuditObserver::class);
        }

        // GeneralSetting observer (privacy policy versioning + service cache)
        GeneralSetting::observe(SiteSettingObserver::class);

        // Share SiteConfigService with all Blade views
        View::share('site', app(SiteConfigService::class));

        // Breadcrumb composer for all front views
        View::composer('front.*', \App\View\Composers\BreadcrumbComposer::class);

        // Track admin logins (fills admins.last_login_at / last_login_ip)
        Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\RecordAdminLogin::class,
        );
    }
}
