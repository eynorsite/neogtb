<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

class MaintenancePage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string|\UnitEnum|null $navigationGroup = 'Réglages';

    protected static ?string $navigationLabel = 'Maintenance';

    protected static ?string $title = 'Maintenance & Cache';

    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.maintenance';

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();

        return $admin && $admin->isAdmin();
    }

    public function clearAllCache(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        Notification::make()->title('Tout le cache a été vidé')->success()->send();
    }

    public function clearConfigCache(): void
    {
        Artisan::call('config:clear');
        Notification::make()->title('Cache de configuration vidé')->success()->send();
    }

    public function clearViewCache(): void
    {
        Artisan::call('view:clear');
        Notification::make()->title('Cache des vues vidé')->success()->send();
    }

    public function clearRouteCache(): void
    {
        Artisan::call('route:clear');
        Notification::make()->title('Cache des routes vidé')->success()->send();
    }

    public function optimize(): void
    {
        Artisan::call('optimize');
        Notification::make()->title('Application optimisée')->success()->send();
    }

    public function toggleMaintenance(): void
    {
        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
            Notification::make()->title('Mode maintenance désactivé')->success()->send();
        } else {
            Artisan::call('down', ['--secret' => 'neogtb-admin-bypass']);
            Notification::make()->title('Mode maintenance activé')->warning()->body('Secret de contournement : neogtb-admin-bypass')->send();
        }
    }
}
