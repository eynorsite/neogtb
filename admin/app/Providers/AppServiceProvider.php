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
use App\Services\HomepageSectionsService;
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
        $this->app->singleton(HomepageSectionsService::class);

        // Force password-reset notification to bypass the queue (QUEUE_CONNECTION=database
        // would otherwise leave the email stuck in the jobs table until a worker runs)
        $this->app->bind(
            \Filament\Auth\Notifications\ResetPassword::class,
            \App\Notifications\ResetPasswordNotification::class
        );

        // Bump memory for admin pages with large forms (SiteSettings labels: 256+ fields)
        if (request()->is('admin*')) {
            ini_set('memory_limit', '512M');
        }
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

        // Inject $site (SiteConfigService) + $settings (GeneralSetting) into front views
        View::composer([
            'front.*',
            'components.front.*',
        ], \App\Http\View\Composers\SiteSettingsComposer::class);

        // Breadcrumb composer for all front views
        View::composer('front.*', \App\View\Composers\BreadcrumbComposer::class);

        // Track admin logins (fills admins.last_login_at / last_login_ip)
        Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\RecordAdminLogin::class,
        );
    }
}
