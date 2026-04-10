<?php

namespace App\Observers;

use App\Models\PrivacyPolicyVersion;
use App\Models\SiteSetting;
use App\Services\SiteConfigService;

class SiteSettingObserver
{
    /**
     * Handle the SiteSetting "saved" event.
     */
    public function saved(SiteSetting $setting): void
    {
        // 1. Invalider le cache model
        SiteSetting::clearCache();

        // 2. Invalider le cache service
        app(SiteConfigService::class)->clearCache();

        // 3. Si politique de confidentialité modifiée, créer une nouvelle version
        if ($setting->key === 'legal_politique_confidentialite' && filled($setting->value)) {
            $this->createPrivacyPolicyVersion($setting);
        }
    }

    /**
     * Handle the SiteSetting "deleted" event.
     */
    public function deleted(SiteSetting $setting): void
    {
        SiteSetting::clearCache();
        app(SiteConfigService::class)->clearCache();
    }

    /**
     * Crée une nouvelle version de politique de confidentialité.
     */
    private function createPrivacyPolicyVersion(SiteSetting $setting): void
    {
        // Désactiver les versions précédentes
        PrivacyPolicyVersion::where('is_current', true)->update(['is_current' => false]);

        // Calculer le prochain numéro de version
        $lastVersion = PrivacyPolicyVersion::max('version') ?? '0.0';
        $parts = explode('.', $lastVersion);
        $major = (int) ($parts[0] ?? 0);
        $minor = (int) ($parts[1] ?? 0);
        $newVersion = $major . '.' . ($minor + 1);

        // Créer la nouvelle version
        PrivacyPolicyVersion::create([
            'version'      => $newVersion,
            'content'      => $setting->value,
            'published_at' => now(),
            'is_current'   => true,
            'created_by'   => auth()->id(),
        ]);
    }
}
