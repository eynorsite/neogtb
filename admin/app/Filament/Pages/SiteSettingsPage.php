<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Livewire\WithFileUploads;

class SiteSettingsPage extends Page
{
    use WithFileUploads;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|\UnitEnum|null $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Paramètres du site';

    protected static ?string $title = 'Paramètres du site';

    protected static ?int $navigationSort = 50;

    protected string $view = 'filament.pages.site-settings';

    public string $activeTab = 'contact';

    public array $settings = [];

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();

        if (! $admin) {
            return false;
        }

        // lecteur: no access
        return in_array($admin->role, ['superadmin', 'admin', 'editeur']);
    }

    public function mount(): void
    {
        $allSettings = SiteSetting::all();

        foreach ($allSettings as $setting) {
            $this->settings[$setting->key] = $setting->value ?? '';
        }
    }

    public function getTabsProperty(): array
    {
        $admin = auth()->guard('admin')->user();
        $role = $admin?->role ?? 'lecteur';

        $tabs = [
            'contact' => ['label' => 'Contact', 'icon' => 'heroicon-o-phone'],
            'reseaux_sociaux' => ['label' => 'Réseaux sociaux', 'icon' => 'heroicon-o-share'],
            'entreprise' => ['label' => 'Entreprise', 'icon' => 'heroicon-o-building-office'],
            'seo' => ['label' => 'SEO', 'icon' => 'heroicon-o-magnifying-glass'],
            'analytics' => ['label' => 'Analytics', 'icon' => 'heroicon-o-chart-bar'],
            'apparence' => ['label' => 'Apparence', 'icon' => 'heroicon-o-paint-brush'],
            'securite' => ['label' => 'Sécurité', 'icon' => 'heroicon-o-shield-check'],
            'maintenance' => ['label' => 'Maintenance', 'icon' => 'heroicon-o-wrench-screwdriver'],
        ];

        // Role-based access
        if ($role === 'editeur') {
            return array_intersect_key($tabs, array_flip(['apparence', 'seo']));
        }

        if ($role === 'admin') {
            unset($tabs['securite'], $tabs['maintenance']);
        }

        return $tabs;
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function save(): void
    {
        $groupSettings = SiteSetting::where('group', $this->activeTab)->get();

        foreach ($groupSettings as $setting) {
            $newValue = $this->settings[$setting->key] ?? '';

            // Skip password fields that are empty (don't overwrite)
            if ($setting->type === 'password' && blank($newValue)) {
                continue;
            }

            // Log sensitive changes masked
            $oldValue = $setting->getRawOriginal('value');

            $setting->value = $newValue;
            $setting->save();
        }

        SiteSetting::clearCache();

        Notification::make()
            ->title('Paramètres enregistrés')
            ->body('Le groupe "' . $this->getTabLabel($this->activeTab) . '" a été sauvegardé.')
            ->success()
            ->send();
    }

    public function clearAllCache(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        Notification::make()->title('Cache vidé avec succès')->success()->send();
    }

    public function optimize(): void
    {
        Artisan::call('optimize');

        Notification::make()->title('Application optimisée')->success()->send();
    }

    protected function getTabLabel(string $tab): string
    {
        return $this->tabs[$tab]['label'] ?? $tab;
    }

    public function getSettingsForGroup(string $group): \Illuminate\Support\Collection
    {
        return SiteSetting::where('group', $group)->orderBy('order')->get();
    }
}
