<?php

namespace App\Providers\Filament;

use App\Filament\GlobalSearch\LabelsGlobalSearchProvider;
use App\Http\Middleware\EnsureAdminIsActive;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Models\GeneralSetting;
use Filament\Actions\Action;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset()
            ->authPasswordBroker('admins')
            ->authGuard('admin')
            ->brandName('NeoGTB Admin')
            ->brandLogo(asset('images/logo-admin.webp'))
            ->brandLogoHeight('3rem')
            ->homeUrl('https://neogtb.fr')
            ->favicon(asset('favicon.svg'))
            ->font('Inter')
            ->sidebarWidth('16rem')
            ->darkMode(false)
            ->maxContentWidth('full')
            ->renderHook('panels::styles.after', fn () => view('filament.hooks.admin-styles'))
            ->renderHook(
                \Filament\View\PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn () => view('filament.hooks.global-search'),
            )
            ->globalSearch(LabelsGlobalSearchProvider::class)
            ->globalSearchKeyBindings(['mod+k'])
            ->globalSearchFieldKeyBindingSuffix()
            ->globalSearchDebounce('250ms')
            ->userMenuItems([
                Action::make('view-public-site')
                    ->label('Voir le site public')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(
                        fn () => GeneralSetting::get()->company_website
                            ?: config('app.url'),
                        shouldOpenInNewTab: true
                    ),
            ])
            ->colors([
                'primary' => [
                    50 => '#F5F3FF',
                    100 => '#EDE9FE',
                    200 => '#DDD6FE',
                    300 => '#C4B5FD',
                    400 => '#A78BFA',
                    500 => '#8B5CF6',
                    600 => '#6C3AED',
                    700 => '#5B21B6',
                    800 => '#4C1D95',
                    900 => '#3B0F7A',
                    950 => '#2E1065',
                ],
                'success' => Color::Emerald,
                'danger' => Color::Rose,
                'warning' => Color::Amber,
                'info' => Color::Sky,
                'gray' => Color::Slate,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsureAdminIsActive::class,
            ])
            // ->spa()
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                \Filament\Navigation\NavigationGroup::make('Mon site')
                    ->icon('heroicon-o-globe-alt'),
                \Filament\Navigation\NavigationGroup::make('Blog')
                    ->icon('heroicon-o-newspaper'),
                \Filament\Navigation\NavigationGroup::make('Boîte de réception')
                    ->icon('heroicon-o-inbox'),
                \Filament\Navigation\NavigationGroup::make('Réglages')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),
            ]);
    }
}
