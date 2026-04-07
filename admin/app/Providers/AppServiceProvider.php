<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\ContactMessage;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\SitePage;
use App\Models\SiteSetting;
use App\Models\PageBrick;
use App\Observers\AdminAuditObserver;
use App\Observers\BrickSyncObserver;
use App\Observers\PageSyncObserver;
use App\Observers\PostSyncObserver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force Carbon locale to French
        Carbon::setLocale('fr');

        // Audit observer on all admin-managed models
        $models = [
            Admin::class,
            SitePage::class,
            SiteSetting::class,
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

        // Auto-sync blog posts to Astro markdown files
        Post::observe(PostSyncObserver::class);

        // Auto-sync pages + bricks to Astro JSON
        SitePage::observe(PageSyncObserver::class);
        PageBrick::observe(BrickSyncObserver::class);

        // Track admin logins (fills admins.last_login_at / last_login_ip)
        Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\RecordAdminLogin::class,
        );
    }
}
