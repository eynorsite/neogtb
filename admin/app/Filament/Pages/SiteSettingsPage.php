<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Livewire\WithFileUploads;

class SiteSettingsPage extends Page
{
    use WithFileUploads;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|\UnitEnum|null $navigationGroup = 'Réglages';

    protected static ?string $navigationLabel = 'Paramètres généraux';

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
            'contact' => ['label' => 'Contact', 'emoji' => '📞'],
            'reseaux_sociaux' => ['label' => 'Réseaux sociaux', 'emoji' => '🔗'],
            'entreprise' => ['label' => 'Entreprise', 'emoji' => '🏢'],
            'seo' => ['label' => 'SEO', 'emoji' => '🔍'],
            'blog' => ['label' => 'Blog', 'emoji' => '📰'],
            'analytics' => ['label' => 'Analytics', 'emoji' => '📊'],
            'apparence' => ['label' => 'Apparence', 'emoji' => '🎨'],
            'securite' => ['label' => 'Sécurité', 'emoji' => '🛡️'],
            'maintenance' => ['label' => 'Maintenance', 'emoji' => '🔧'],
            'theme' => ['label' => 'Thème', 'emoji' => '🎭'],
            'legal' => ['label' => 'Juridique', 'emoji' => '⚖️'],
            'navigation' => ['label' => 'Navigation', 'emoji' => '☰'],
            'email' => ['label' => 'Email', 'emoji' => '✉️'],
        ];

        // Role-based access
        if ($role === 'editeur') {
            return array_intersect_key($tabs, array_flip(['apparence', 'seo', 'blog']));
        }

        if ($role === 'admin') {
            unset($tabs['securite'], $tabs['maintenance'], $tabs['email']);
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

    public function applyPreset(string $preset): void
    {
        $values = config("neogtb.presets.{$preset}");

        if (! $values) {
            Notification::make()->title('Preset introuvable')->danger()->send();
            return;
        }

        foreach ($values as $key => $value) {
            $this->settings[$key] = $value;

            SiteSetting::where('key', $key)->update(['value' => $value]);
        }

        SiteSetting::clearCache();

        Notification::make()
            ->title('Preset appliqué')
            ->body('Les couleurs du thème ont été mises à jour.')
            ->success()
            ->send();
    }

    public function sendTestEmail(): void
    {
        $to = $this->settings['email_notification_to'] ?? null;
        $fromName = $this->settings['email_from_name'] ?? config('mail.from.name');
        $fromAddress = $this->settings['email_from_address'] ?? config('mail.from.address');

        if (! $to) {
            Notification::make()->title('Adresse de notification manquante')->danger()->send();
            return;
        }

        try {
            Mail::raw('Ceci est un email de test envoyé depuis NeoGTB Admin.', function ($message) use ($to, $fromName, $fromAddress) {
                $message->to($to)
                    ->from($fromAddress, $fromName)
                    ->subject('NeoGTB - Email de test');
            });

            Notification::make()
                ->title('Email de test envoyé')
                ->body("Un email a été envoyé à {$to}.")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Erreur d\'envoi')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
