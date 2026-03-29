<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsureAdminIsActive;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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
            ->authGuard('admin')
            ->brandName('NeoGTB Admin')
            ->brandLogo(asset('images/logo-admin.webp'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('favicon.svg'))
            ->font('Inter')
            ->sidebarWidth('16rem')
            ->darkMode(true)
            ->maxContentWidth('full')
            ->renderHook('panels::styles.after', fn () => view('filament.hooks.admin-styles'))
            ->colors([
                'primary' => [
                    50 => '#f0f6fb',
                    100 => '#dce8f3',
                    200 => '#b8d1e8',
                    300 => '#84b0d6',
                    400 => '#5a94c4',
                    500 => '#3574a8',
                    600 => '#1B3A5C',
                    700 => '#183353',
                    800 => '#142b47',
                    900 => '#10233b',
                    950 => '#08111f',
                ],
                'success' => [
                    50 => '#ecfdf5',
                    100 => '#d1fae5',
                    200 => '#a7f3d0',
                    300 => '#6ee7b7',
                    400 => '#34d399',
                    500 => '#10b981',
                    600 => '#059669',
                    700 => '#047857',
                    800 => '#065f46',
                    900 => '#064e3b',
                    950 => '#022c22',
                ],
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
            ->spa()
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
