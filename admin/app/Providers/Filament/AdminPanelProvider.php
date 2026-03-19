<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsureAdminIsActive;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
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
            ->favicon(asset('favicon.ico'))
            ->font('Inter')
            ->sidebarWidth('16rem')
            ->darkMode(false)
            ->maxContentWidth('full')
            ->renderHook('panels::styles.after', fn () => view('filament.hooks.admin-styles'))
            ->colors([
                'primary' => [
                    50 => '#e6f0f7',
                    100 => '#cce1ef',
                    200 => '#99c3df',
                    300 => '#66a5cf',
                    400 => '#3387bf',
                    500 => '#0F6BAF',
                    600 => '#0d5f9c',
                    700 => '#0a4b7d',
                    800 => '#08385e',
                    900 => '#05253f',
                    950 => '#031220',
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
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
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
                'Contenu',
                'Blog',
                'Communication',
                'Configuration',
                'Système',
            ]);
    }
}
